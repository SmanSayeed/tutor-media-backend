<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login(){
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Try authentication with web guard first (for customers)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        // If web guard fails, try admin guard
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::guard('admin')->user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    private function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            case 'customer':
                return redirect('/')->with('success', 'Welcome back!');
            case 'vendor':
                return redirect('/')->with('success', 'Welcome back!');
            default:
                return redirect('/')->with('success', 'Welcome back!');
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return $this->redirectBasedOnRole(Auth::user());
            }
            return view('auth.register');
        }

        // Handle POST request (form submission)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'customer', // Default role for new registrations
            'is_active' => true,
        ]);

        // Log the user in after successful registration
        Auth::login($user);

        return redirect('/')->with('success', 'Welcome! Your account has been created successfully.');
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

    if (!$user) {
        return redirect()->route('check-email', ['email' => $request->email])->withErrors([
            'email' => 'No account found with this email address.',
        ]);
    }

    if (!$user->is_active) {
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
        if (!$email && !$message) {
            return redirect()->route('forgot-password');
        }

        return view('auth.check-email', compact('email', 'message'));
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return $this->redirectBasedOnRole(Auth::user());
            }

            // Check if token and email are provided
            $token = $request->query('token');
            $email = $request->query('email');

            if (!$token || !$email) {
                return redirect()->route('forgot-password')->withErrors([
                    'email' => 'Invalid password reset link. Please request a new one.'
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

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
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

        return redirect()->route('login')->with('success', 'Password has been reset successfully. You can now log in with your new password.');
    }
}
