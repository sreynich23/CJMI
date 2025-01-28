<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $countries = json_decode(file_get_contents(public_path('storage/countries.json')), true);
        return view('auth.register', compact('countries'));
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
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'country' => 'nullable|string|min:2|max:2',
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
                'reviewer_available' => $request->has('reviewer'),
                'country' => strtoupper($request->country),
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
}
