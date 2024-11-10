<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        
    }

    public function loadUserPage()
    {
        return view('Backend.user.index');
    }

    public function loadUserAccountPage()
    {
        return view('Backend.user.account');
    }
}
