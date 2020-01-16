<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success, 'user' => $user], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone_no' => 'required',
        ]);
        
        $email_exist = User::where('email', '=', $request->email)->exists();
        
        if($email_exist){
            return response()->json(['error' => "email already exist"]);
        }

        $name  = $request->name;
        $usernames = explode(" ", $name);
        $username = " ";
        
        if(count($usernames) > 1){
            foreach ($usernames as $new_username) {
                if($username == " "){
                    $username = $new_username;
                }else{
                    $username = $username.$new_username;
                }
            }
        }else{
            $username = $usernames[0];
        }

        $username = $username.rand(10,1000);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['username'] = $username;
        $input['status'] = 0;
        $input['ip_address'] = $request->ip();

        // return response()->json($input);

        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success' => $success, 'user' => $user], $this->successStatus);
    }
    

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
