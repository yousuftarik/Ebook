<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;



use App\Models\PasswordReset;
class PasswordResetController extends Controller
{
    

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', '=', $request->email)->first();
       
        if (!$user){
            return response()->json([
                'message' => 'We can not find a user with that e-mail address and resturant.'
            ], 404);
        }else{

                $passwordReset = PasswordReset::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'email' => $user->email,
                        'token' => str_random(5)
                    ]
                );
                

                if ($user && $passwordReset){
                    $token = $passwordReset->token;
                    $email = $request->email;
                   $user->notify(new PasswordResetRequest($token, $email));
                   // Notification::send($users, new PasswordResetRequest($token));

                    return response()->json([
                        'message' => 'We have sent a confirmation code on your email!'
                    ]);
                }  

        }
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token, $email)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            // return response()->json([
            //     'message' => 'This password reset token is invalid.'
            // ], 404);
            return view('frontend.partials.passResetfalse');
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            // return response()->json([
            //     'message' => 'This password reset token is invalid.'
            // ], 404);
            return view('frontend.partials.passResetfalse');
        }
        //return response()->json($passwordReset);
        $code = $passwordReset->token;
        return view('frontend.partials.passReset', compact('code', 'email')); 

    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'token' => 'required|string',
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email],

        ])->first();
        if (!$passwordReset)
           {
                $message = 'This password reset token is invalid.';
                return view('frontend.partials.passResetMsg', compact('message'));
            }
        $user = User::where('email', '=', $request->email)
                ->first();

        if (!$user){ 
            $message = 'We can not find a user with that e-mail address and resturant';
            return view('frontend.partials.passResetMsg', compact('message'));
        }
       
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        $message = 'Password has reset successfully';
        return view('frontend.partials.passResetMsg', compact('message'));
    }
}