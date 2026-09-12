<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function index()
    {
        return view('admin.profile');
    }
}
