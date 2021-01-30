<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;


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
            'phone' => ['integer'],
            'password_confirmation' => 'required|same:password|min:5',
            'company_name' => ['required', 'string']
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
        $company_status = Company::where("company_name", $request->company_name)->first();
        
        if(!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! Email already registered!"]);
         }
         if(!is_null($company_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! Copmany name is not available!"]);
         }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone' => $request['phone'],
            'profile' => $path
        ]);
        $company = Company::create([
            'company_name' => $request['company_name']
        ]);
        $user->sendEmailVerificationNotification();

        if(!(is_null($user) && is_null($company))) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Registration completed successfully", "data" => $user]);
        }
        
        return response()->json(["status" => "failed", "success" => false, "message" => "Failed to register"]);
    }
        
     
    protected function guard(){
        Auth::guard();
    }
    public function login(Request $request){
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $request['remember'])){
            $user = Auth::user();
            if($user->email_verified_at !== NULL){
                return response()->json(['message' => 'Login successful'], 200);
            }else{
                return response()->json(['message'=> 'Please Verify Email'], 401);}}
        else{
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
    }
    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}

