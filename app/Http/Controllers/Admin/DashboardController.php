<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();          
    
        return view('admin.dashboard', [
            'totalCustomers' => $totalCustomers,       
        ]);
    }
}
