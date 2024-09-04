<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function addForm(){
        return view('admin.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Nouvel administrateur ajouté avec succès.');
    }

    public function list(){
        $users = User::where('role', 'agent')->get();
        return view('admin.list', compact('users'));
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
