<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\Users;

class AutentificacionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function logout(Request $request)
    {

        dd($request->header('Authorization'));
       
        if ($request->header('Authorization')) {
          $key = explode(' ',$request->header('Authorization'));
          $user = Users::where('api_key', $key)->first();
          
          $Users=Users::findOrFail($user->id);
          $Users->api_key='';
          if ($Users->update()) {
           return response()->json(['status' => 'success','message' => 'loguot correcto']); 
          }
          return response()->json(['status' => 'fail','message' => 'cancelado por el usuario']);  
        }
        

    }

}
