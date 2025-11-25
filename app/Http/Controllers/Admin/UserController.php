<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['orders' => function($query) {
            $query->latest()->limit(1);
        }])
        ->where('role', 'customer') // Only show customer users in admin panel
        ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.user-details', compact('user'));
    }
}
