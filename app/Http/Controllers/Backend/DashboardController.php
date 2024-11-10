<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        
    }

    public function loadDashboard() {
        $config = $this->config();
        return view('Backend.dashboard.home.home', compact(
            'config'
        ));
    }

    private function config() {
        return [
            'js' => [
                'assets/js/custom/widgets.js',
                'assets/js/custom/apps/chat/chat.js',
                'assets/js/custom/modals/create-app.js',
                'assets/js/custom/modals/upgrade-plan.js'
            ]
        ];
    }
    
}
