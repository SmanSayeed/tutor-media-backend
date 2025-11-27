<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\UserStatusEnum;
use App\Exceptions\CustomWebException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use App\Traits\EmailAndPhoneOTPVerification;
use App\Traits\Formatter;
use App\Traits\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use EmailAndPhoneOTPVerification, Formatter, MediaUploader;

    public function register(StoreUserRequest $request)
    {

        try {
            DB::beginTransaction();

            $user = User::create($request->validated());
            /**
             * check referer exists and give referral bonus
             */
            if ($request->referer) {
                $sponsor = User::where('username', $request->referer)->first();
                if (! $sponsor) {
                    return $this->withError('referer not found');
                }

                $user->referer_id = $sponsor->id;
                $user->save();
            }

            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

            DB::commit();

            return $this->withSuccess([
                'token' => $token,
                'user' => $user,
                'message' => __('Registration completed successfully'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->withError($th->getMessage());
        }
    }

    public function login(Request $request)
    {

        $params = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $filter_filed = filter_var($params['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($filter_filed, $params['username'])->first();

        if (! $user || ! Hash::check($params['password'], $user->password)) {
            throw ValidationException::withMessages(['username' => __('The provided credentials are incorrect.')]);
        }

        $this->checkUserIsBanned($user);

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return $this->withSuccess([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function redirectToProvider(Request $request, $provider)
    {
        $redirect_url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        if ($request->has('referer')) {
            return $this->withSuccess(['redirect_url' => $redirect_url.'&referer='.$request->referer]);
        }

        return $this->withSuccess(['redirect_url' => $redirect_url]);
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $exception) {
            return $this->withError($exception->getMessage());
        }

        try {
            DB::beginTransaction();
            $userCreated = User::firstOrCreate(
                [
                    'email' => $user->getEmail(),
                    'provider_id' => $user->getId(),
                ],
                [
                    'email_verified_at' => now(),
                    'first_name' => $user->getName(),
                    'avatar' => $user->getAvatar(),
                ]
            );

            $this->checkUserIsBanned($userCreated);

            $token = $userCreated->createToken(self::TOKEN_NAME)->plainTextToken;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->withError($th->getMessage());
        }

        return $this->withSuccess([
            'token' => $token,
            'user' => $userCreated->load('kyc'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user('client')->currentAccessToken()->delete();

        return $this->withSuccess('Logged out successfully');
    }

    public function me(Request $request)
    {
        $user = $request->user('client');

        return $this->withSuccess($user);
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $request->user('client');

        if ($request->password && ! $request->old_password) {
            throw ValidationException::withMessages(['old_password' => __('The old password field is required.')]);
        }

        if ($request->password && $request->old_password) {
            $user = $request->user('client');

            if (! Hash::check($request->old_password, $user->password)) {
                throw ValidationException::withMessages(['old_password' => __('The old password is incorrect.')]);
            }
        }

        $user->update($request->validated());

        return $this->withSuccess($user);
    }

    public function sendOtp(Request $request)
    {
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        if ($user?->isAdmin()) {
            return $this->withError(__('Admin cannot send OTP'));
        }

        $request->validate([
            'type' => 'required|in:email,phone',
            'email' => 'required_if:type,email|email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
        ]);

        $this->{$request->type === 'email' ? 'sendEmailOtp' : 'sendPhoneOtp'}($request);

        return $this->withSuccess(__('OTP sent successfully'));
    }

    public function verifyEmailOrPhone(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,phone',
            'email' => 'required_if:type,email|email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
            'otp' => 'required|numeric',
        ]);

        if (! $this->verifyOtp($request->type, $request->{$request->type}, $request->otp)) {
            return $this->withError(__('Invalid OTP'));
        }

        $message = __('Phone verified successfully');

        if ($request->type == 'phone') {
            $user = User::where('phone', $request->phone)->first();

            if (! $user) {
                return $this->withError(__('You need to add phone first.'));
            }

            if ($user->hasVerifiedPhone()) {
                return $this->withError(__('Phone already verified'));
            }
            $user->markPhoneAsVerified();

        } elseif ($request->type == 'email') {
            $user = User::where('email', $request->email)->first();
            if ($user->hasVerifiedEmail()) {
                return $this->withError(__('Email already verified'));
            }
            $user->markEmailAsVerified();
            $message = __('Email verified successfully');
        }

        return $this->withSuccess($message);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,phone',
            'email' => 'required_if:type,email|email|exists:users,email',
            'phone' => 'required_if:type,phone|exists:users,phone',
            'otp' => 'nullable',
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                Password::defaults()->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $type = $request->type;
        $value = $request->{$type};
        $otp = $request->otp;
        $password = $request->password;
        $cacheKey = $this->generateKey("{$type}-verified", $value);

        if (! $password && ! Cache::has($cacheKey) && ! $otp) {
            throw ValidationException::withMessages(['otp' => __('otp is required')]);
        }

        // Step 1: OTP Verification
        if ($otp) {
            if (! $this->verifyOtp($type, $value, $otp)) {
                return $this->withError(__('Invalid OTP'));
            }

            Cache::rememberForever($cacheKey, fn () => json_encode([
                'type' => $type,
                'value' => $value,
            ]));

            return $this->withSuccess(__('OTP verified successfully'));
        }

        // Step 2: Password Change
        if (! Cache::has($cacheKey)) {
            return $this->withError(__('Please verify your OTP first'));
        }

        if (! $password) {
            throw ValidationException::withMessages(['password' => __('Password is required!')]);
        }

        $cacheValue = json_decode(Cache::get($cacheKey));
        $user = User::where($cacheValue->type, $cacheValue->value)->first();

        if (! $user) {
            return $this->withError(__('User not found'));
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        Cache::forget($cacheKey);

        return $this->withSuccess(__('Password changed successfully'));
    }

    private function verifyOtp(string $type, string $value, string $otp): bool
    {
        // Allow static OTP in local environment for testing
        if (! app()->environment('production') && $otp === '12345') {
            return true;
        }

        return $type === 'email'
            ? $this->verifyEmailOtp(new Request(['email' => $value, 'otp' => $otp]))
            : $this->verifyPhoneOtp(new Request(['phone' => $value, 'otp' => $otp]));
    }

    private function checkUserIsBanned($user)
    {
        throw_if($user->status == UserStatusEnum::BANNED, new CustomWebException(__('Your account is banned. Please contact admin.')));
    }
}
