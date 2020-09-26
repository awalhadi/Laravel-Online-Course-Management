<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // admin dashboard
    public function dashboard(Request $request){
        $admin = Admin::first();
        $page_title = "Admin Dashboard";
        return view('admin.dashboard', compact('page_title','admin'));
    }
}
