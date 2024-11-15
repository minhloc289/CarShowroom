<?php

namespace App\Http\Controllers\fontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerDashBoardController extends Controller
{
    public function index(){
        return view("fontend.home.home");
    }

    public function compare(){
        return view("fontend.compareCar.compare_car");
    }
}
