<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log in with the provided credentials
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Check user role and redirect accordingly
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin'); // Redirect to Admin Dashboard
            }
            return redirect()->intended('/'); // Redirect regular users

        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
                ],
            ], [
                'password.regex' => 'Password must contain at least one letter and one number',
                'email.unique' => 'This email address is already registered',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'notifications_enabled' => $request->has('notifications'),
                'reviewer_available' => $request->has('reviewer')
            ]);

            Auth::login($user);

            return redirect('/')->with('success', 'Registration successful! Welcome to our platform.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Registration error: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $request->email, // Log only email for debugging
            ]);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['general' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
