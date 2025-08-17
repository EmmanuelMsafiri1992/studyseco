<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('profile');

        return response()->json($user);
    }

    /**
     * Update the user's profile.
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'phone'));
        $user->profile->update($request->only('bio', 'school_name'));

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'profile_update',
            'description' => 'User updated their profile information.',
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user->load('profile')]);
    }

    /**
     * Update parent/guardian information.
     */
    public function updateParentInfo(Request $request)
    {
        $user = $request->user();
        // Simple validation, more robust validation can be added
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
        ]);

        $user->profile->update($request->only('parent_name', 'parent_phone', 'parent_email'));

        return response()->json(['message' => 'Parent/guardian information updated successfully.']);
    }

    /**
     * Change the user's password.
     */
    public function changePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'password_change',
            'description' => 'User changed their password.',
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Password changed successfully.']);
    }

    /**
     * Deactivate the user's account.
     */
    public function deactivate(Request $request)
    {
        $user = $request->user();
        $user->is_active = false;
        $user->save();

        // Revoke all Sanctum tokens for the deactivated user
        $user->tokens()->delete();

        // Log the activity
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'account_deactivation',
            'description' => 'User deactivated their account.',
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['message' => 'Account deactivated successfully.']);
    }

    /**
     * Upload an avatar with image processing.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048', // 2MB max
        ]);

        $user = $request->user();
        $path = $request->file('avatar')->store('avatars', 'public');

        // Optional: Implement image processing here (e.g., resizing, cropping)
        // using a library like Intervention Image.
        // For example: Image::make(public_path('storage/' . $path))->fit(200, 200)->save();

        // Delete the old avatar if it exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $path;
        $user->save();

        return response()->json(['message' => 'Avatar uploaded successfully.', 'avatar_url' => asset('storage/' . $path)]);
    }
}
