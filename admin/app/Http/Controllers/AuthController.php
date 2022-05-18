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

    public function home(){
        return view('home');

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
            return Redirect('home');
        }else{
            return back()->with('error', 'Email ou Password errados');
        }

    }

    public function VerifyAdmin(Request $request){

        $admin = new Admin;
        $admin ->setConnection('mysql2');

        $result = $admin::where('username', $request->username)->first();

        if(!$result || !Hash::check($request->password, $result->password)){
            return FALSE;
        }

        session()->put('ADMIN_username', $request->username);
        session()->put('ADMIN_cargo', $result->cargo);
        session()->put('ADMIN_id', $result->id);

        return TRUE;
    }

    public function CreateAdmin(){

        $fornecedor = Admin::create([
            'username' => "admin",
            'password' => bcrypt("admin"),
            'cargo' => "Manager"
        ]);
    }
}
