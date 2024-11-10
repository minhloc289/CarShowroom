<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Flasher\Laravel\Facade\Flasher;

class AuthController extends Controller
{
    public function __construct()
    {
        
    }

    public function index() {
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('Backend.auth.login');
    }

    public function login(AuthRequest $request) {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
    
        if (Auth::attempt($credentials)) {
            session()->flash('success', 'Đăng nhập thành công');
            return redirect()->route('dashboard');    
        } 
        return back()->with('error', 'Email hoặc mật khẩu không chính xác!')->withInput();
    }
    
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('auth.admin');
    }

}
