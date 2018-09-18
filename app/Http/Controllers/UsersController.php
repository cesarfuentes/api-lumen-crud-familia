<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use App\Users;

 
class UsersController extends Controller
 
{
 
  public function __construct()
 
   {
 
     //  $this->middleware('auth:api');
 
   }
 
   /**
 
    * Display a listing of the resource.
 
    *
 
    * @return \Illuminate\Http\Response
 
    */
 
   public function authenticate(Request $request)
 
   {
 
       $this->validate($request, [
 
       'email' => 'required',
 
       'password' => 'required'
 
        ]);
 
      $user = Users::where('email', $request->input('email'))->first();
 
     if(Hash::check($request->input('password'), $user->password)){
 
          $apikey = base64_encode(str_random(40));
 
          Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);
 
          return response()->json(['status' => 'success','api_key' => $apikey]);
 
      }else{
 
          return response()->json(['status' => 'fail'],401);
 
      }
 
   }

   public function Register(Request $request){
    
      $this->validate($request, [
       'username' => 'required',
       'email' => 'required',
       'password' => 'required',
       'userimage' => 'required'
        ]);

        $dato=[];
        $user=new Users;
        $user->username=$request->get('username');
        $user->email=$request->get('email');
        $user->password=App('hash')->make($request->get('password'));
        $user->userimage=$request->get('userimage');
        
       if ($user->save()) {
          $dato['status']='success';
          $dato['message']='se ingreso correctamente';
       }else{
          $dato['status']='fail';
          $dato['message']='error al ingresar';
       }
        return response()->json($dato);
   }

   
   public function showUsers(){
           $user = Users::all();   
           return response()->json($user);
   }
 
}    
 
?>