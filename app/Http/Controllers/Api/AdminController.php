<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a list of all users with filters and search.
     */
    public function listUsers(Request $request)
    {
        $query = User::with('profile')->orderBy('created_at', 'desc');

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        // Add parent/guardian search functionality
        if ($request->has('parent_search')) {
            $search = '%' . $request->parent_search . '%';
            $query->whereHas('profile', function($q) use ($search) {
                $q->where('parent_name', 'like', $search);
            });
        }

        $users = $query->paginate(20);

        return response()->json($users);
    }

    /**
     * Show a specific user's details.
     */
    public function showUser(User $user)
    {
        $user->load('profile', 'activityLogs');
        return response()->json($user);
    }

    /**
     * Assign a new role to a user.
     */
    public function assignRole(UpdateUserRoleRequest $request, User $user)
    {
        $user->syncRoles([$request->role]);

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'role_assignment',
            'description' => 'Changed user ' . $user->email . ' role to ' . $request->role . '.',
        ]);

        return response()->json(['message' => 'User role updated successfully.', 'user' => $user->refresh()]);
    }

    /**
     * Approve a pending account (for teachers).
     */
    public function approveAccount(User $user)
    {
        $user->status = 'approved';
        $user->is_active = true;
        $user->save();

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'account_approval',
            'description' => 'Approved user ' . $user->email . '.',
        ]);

        return response()->json(['message' => 'Account approved successfully.']);
    }

    /**
     * Reject a pending account (for teachers).
     */
    public function rejectAccount(User $user)
    {
        $user->status = 'rejected';
        $user->is_active = false;
        $user->save();

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'account_rejection',
            'description' => 'Rejected user ' . $user->email . '.',
        ]);

        return response()->json(['message' => 'Account rejected successfully.']);
    }

    /**
     * Perform bulk account approval.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = User::whereIn('id', $request->user_ids)
            ->where('role', 'teacher')
            ->where('status', 'pending')
            ->update(['status' => 'approved', 'is_active' => true]);

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'bulk_approval',
            'description' => 'Approved ' . $count . ' teacher accounts.',
        ]);

        return response()->json(['message' => "Successfully approved {$count} accounts."]);
    }
}
