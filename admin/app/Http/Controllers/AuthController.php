<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{ 
    public function index()
    {
        return view('login');
    } 

    public function dashboard(){
        return view('dashboard');

    }
    
    public function signOut() {
        Session::flush();
  
        return Redirect('login');
    }
      
    public function checklogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
       
        if ($this->VerifyAdmin($request)){
            return Redirect('dashboard');
        }else{
            return back()->with('error', 'Email ou Password errados');
        }

    }

    public function VerifyAdmin(Request $request){
        $admin = Admin::where('username', $request->username)->first();

        if(!$admin || !Hash::check($request->password, $admin->password)){
            return FALSE;
        }

        session()->put('ADMIN_username', $request->username);
        session()->put('ADMIN_cargo', $admin->cargo);
        session()->put('ADMIN_id', $admin->id);

        return TRUE;
    }
}
