<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;


class VerificationController extends VerifyEmail
{
    
    public function show()
    {
    //
    }
    /**
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function verify(Request $request) {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date("F j, Y, g:i a");
        $user->email_verified_at = $date; 
        $user->save();
        return response()->json(['message'=>'Email verified!']);
    }
    /**
    *
    * @param \Illuminate\Http\Request 
    * @return \Illuminate\Http\Response
    */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'User already have verified email!'], 422);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'The notification has been resubmitted']);
    }
    
    public function forgotPassword(Request $request){
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $status = Password::sendResetLink($input);
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        /*$response =  Password::sendResetLink($input);
         if($response == Password::RESET_LINK_SENT){
            $message = "Mail send successfully";
        }else{
            $message = "Email could not be sent to this email address";
        } 
        $response = ['data'=>'','message' => $message];
        return response($response, 200);*/
    }

    public function passwordReset(Request $request){
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
        $message = $response == Password::PASSWORD_RESET ? 'Password reset successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        return response()->json($message);
    }
}
