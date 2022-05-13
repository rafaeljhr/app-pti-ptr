<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function index()
    {
        $users =  Admin::all();
        
        return view('admins', compact('users'));
    } 

    public function addAdmin(Request $request)
    {

        $request->validate([
            'admin_username' => 'required',
            'admin_password' => 'required',
            'admin_cargo' => 'required',
        ]);


        $admin = Admin::create([
            'username' => $request->admin_username,
            'password' => bcrypt($request->admin_password),
            'cargo' => $request->admin_cargo[0],
        ]);
        
        return $this->index();

    }
}
