<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function index()
    {
        $name = Auth::getName();
        // dd($name);
        return view('admin.profile', compact(['name']));
    }
}
