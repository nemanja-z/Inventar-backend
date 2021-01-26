<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;

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
}
