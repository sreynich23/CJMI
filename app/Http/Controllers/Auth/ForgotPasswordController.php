<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Generate OTP and store it in the cache
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10)); // Valid for 10 minutes

        // Send OTP via email
        Mail::to($user->email)->send(new \App\Mail\SendOtp($otp));

        return redirect()->route('reset-password')->with('email', $user->email);
    }

    public function showResetPasswordForm()
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
            'password' => 'required|confirmed|min:8',
        ]);

        // Verify OTP from cache
        $cachedOtp = Cache::get('otp_' . $request->email);
        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear OTP from cache
        Cache::forget('otp_' . $request->email);

        return redirect()->route('login')->with('success', 'Password reset successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 422);
        }
        User::find(Auth::id())->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->with(['message' => 'Password changed successfully']);

    }
}
