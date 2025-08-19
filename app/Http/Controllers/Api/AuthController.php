<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterStudentRequest;
use App\Http\Requests\RegisterTeacherRequest;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle student registration.
     */
    public function registerStudent(RegisterStudentRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Create the user profile
        $user->profile()->create([
            'school_name' => $request->school_name,
        ]);

        // Trigger email verification event
        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Student account created successfully. Please verify your email.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    /**
     * Handle teacher registration.
     */
    public function registerTeacher(RegisterTeacherRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'status' => 'pending', // Teachers need admin approval
        ]);

        // Create the user profile with qualification
        $user->profile()->create([
            'qualification' => $request->qualification,
            'experience_years' => $request->experience_years,
        ]);

        // Trigger email verification event
        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Teacher application submitted successfully. Your account is pending admin approval. Please verify your email.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $user = Auth::user();

        // Check if the user's account is active
        if (!$user->is_active) {
            Auth::logout();
            return response()->json(['message' => 'Your account is deactivated.'], 403);
        }

        // Check if teacher account is approved
        if ($user->role === 'teacher' && $user->status !== 'approved') {
            Auth::logout();
            return response()->json(['message' => 'Your account is pending admin approval.'], 403);
        }

        // Revoke old tokens if necessary
        $user->tokens()->delete();

        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Update last login timestamp
        $user->update(['last_login_at' => Carbon::now()]);

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'login',
            'description' => 'User logged in.',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'message' => 'Logged in successfully.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * Handle email verification.
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link.'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully.']);
    }

    /**
     * Resend the email verification link.
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 409);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link resent.']);
    }

    /**
     * Mock a phone number verification.
     * In a real app, this would be a full SMS service.
     */
    public function verifyPhoneNumber(Request $request)
    {
        // For simplicity, we'll mock OTP. In a real app, an OTP would be generated
        // and sent via SMS (e.g., using Twilio) and then validated here.
        $request->validate(['phone' => ['required', 'string', 'phone:MW']]);

        $user = $request->user();
        $user->phone = $request->phone;
        $user->phone_verified_at = Carbon::now();
        $user->save();

        return response()->json(['message' => 'Phone number verified successfully.']);
    }

    /**
     * Resend a phone number OTP.
     */
    public function resendPhoneOTP(Request $request)
    {
        // This would trigger a real SMS service to resend the OTP.
        // For this example, we just return a success message.
        return response()->json(['message' => 'OTP resent to your phone number.']);
    }
}
