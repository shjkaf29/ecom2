<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function viewUsers() {
        $users = User::where('user_type', 'user')->get();
        return view('admin.users.view_users', compact('users'));
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'user_type' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        
        $user->update($request->only(['name', 'email', 'user_type']));

        return redirect()->route('admin.users')->with('message', 'User updated successfully!');
    }

    public function deleteUser($id) {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('message', 'User deleted successfully!');
    }
}
