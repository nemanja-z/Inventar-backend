<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;



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
                 ? response()->json(['message' => 'Reset link has been sent to your email!', 'success'=>true, 'status' => __($status)])
                 : response()->json(['message' => 'Reset link couldn\'t be sent!', 'success'=>false, 'status' => __($status)]);
    }

    public function passwordReset(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
    
                $user->setRememberToken(Str::random(60));
    
                event(new PasswordReset($user));
            }
        );
    
        return $status == Password::PASSWORD_RESET 
            ? response()->json(['message' => 'Your password is changed!','success'=>true, 'status' => __($status)])
            : response()->json(['message' => 'Your password isn\'t changed!', 'success'=>false, 'status' => __($status)]);
    }
}
