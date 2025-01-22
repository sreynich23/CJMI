<form action="{{ route('reset-password') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">
    <label for="otp">OTP</label>
    <input type="text" name="otp" id="otp" required class="block w-full border rounded p-2">
    <label for="password">New Password</label>
    <input type="password" name="password" id="password" required class="block w-full border rounded p-2">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full border rounded p-2">
    <button type="submit" class="w-full bg-green-700 text-white p-2 rounded">
        Reset Password
    </button>
</form>
