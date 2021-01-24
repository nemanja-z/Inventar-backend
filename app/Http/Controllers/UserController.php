<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $status_code = 200;
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => ['integer']
        ]);
        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
        if($request->hasFile('profile'))
        {
            $destinationPath = 'public/images/profile/';
            $profile_name = time().'profile';
            $request->profile->move($destinationPath, $profile_name);
            $path = $destinationPath . '/' . $profile_name;
        }
        $user_status = User::where("email", $request->email)->first();

        if(!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! email already registered"]);
         }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'profile' => $path
        ]);
        
        if(!is_null($user)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Registration completed successfully", "data" => $user]);
        }

        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "failed to register"]);
        }
    }
        
        /* ->all())->validate();
        $user=$this->create($request->all());
        $this->guard()->login($user);
        return response()->json([
            'user'=>$user,
            'message'=>'registration successful'
        ], 200); */
        
    /* protected function validator(array $request)
    {
         Validator::make($request, [
            
        ]);
        
    }
    protected function create(array $request){
        //$path = $request->file('profile')->store('profile');
        return User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone']
        ]);} */
    protected function guard(){
        Auth::guard();
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)){
            $authuser = auth()->user();
            return response()->json(['message' => 'Login successful'], 200);
        }else{
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
    }
    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}

