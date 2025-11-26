<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(AdminLoginRequest $request)
    {
        dd($request->only(['email', 'password']));
        $request->authenticate();

        $request->session()->regenerate();

        $request->session()->put('user_id', Auth::guard('admin')->user()->id);

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    public function logout(Request $request)
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('admin/login')->with('success', 'You have been logged out successfully.');
    }

    public function forgot_password(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return $this->redirectBasedOnRole(Auth::user());
            }

            return view('auth.forgot-password');
        }

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->route('check-email', ['email' => $request->email])->withErrors([
                'email' => 'No account found with this email address.',
            ]);
        }

        if (! $user->is_active) {
            return redirect()->route('check-email', ['email' => $request->email])->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        // Generate and send password reset token (only once)
        $token = Password::createToken($user);
        $user->sendPasswordResetNotification($token);

        return redirect()->route('check-email', ['email' => $request->email])->with('success', 'Password reset link has been sent to your email address.');
    }

    public function check_email(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $email = $request->query('email');
        $message = session('success');

        // If no email provided and no success message, redirect to forgot password
        if (! $email && ! $message) {
            return redirect()->route('forgot-password');
        }

        return view('auth.check-email', compact('email', 'message'));
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('get')) {

            // Check if token and email are provided
            $token = $request->query('token');
            $email = $request->query('email');

            if (! $token || ! $email) {
                return redirect()->route('admin.forgot-password')->withErrors([
                    'email' => 'Invalid password reset link. Please request a new one.',
                ]);
            }

            return view('auth.reset-password', compact('token', 'email'));
        }

        // Handle POST request (form submission)
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        if (! $user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Attempt to reset the password
        $status = app('auth.password.broker')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = $password;
                $user->save();

                // Reset login attempts after successful password reset
                $user->resetLoginAttempts();
            }
        );

        if ($status == 'passwords.token') {
            return back()->withErrors([
                'token' => 'Invalid or expired password reset token.',
            ]);
        }

        if ($status == 'passwords.user') {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ]);
        }

        return redirect()->route('admin.login')->with('success', 'Password has been reset successfully. You can now log in with your new password.');
    }
}
