<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();

            case 'agent':
                return $this->agentDashboard();

            case 'client':
                return $this->clientDashboard();
                
            default:
                return redirect()->route('login');
                
        }
    }

    

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function agentDashboard()
    {
        return view('agents.dashboard');
    }

    public function clientDashboard()
    {
        return view('clients.dashboard');
    }

}
