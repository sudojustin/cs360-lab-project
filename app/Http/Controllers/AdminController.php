<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showAdminDashboard()
    {
        // Fetches all users
        // FIXME: Change to orders
        $users = User::all();

        return view('admin-dashboard', compact('users')); // Pass users to the view
    }
}
