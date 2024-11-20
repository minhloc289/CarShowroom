<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function viewprofile(Request $request){
        return view("frontend.profilepage.viewprofile");
    }
}
