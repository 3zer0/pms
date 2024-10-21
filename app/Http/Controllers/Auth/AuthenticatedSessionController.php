<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Models\UserAuthenticate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AuthenticatedSessionController extends Controller
{
    use ResponseTrait;

    /**
     * Validate user credential
     */

    public function authenticate(Request $request) 
    {
        // Input Validation
        $validator = Validator::make($request->only('username', 'password'), [
            'username' => ['required', 'string', 'min:5', 'max:15'],
            'password' => ['required', 'string', 'min:6'],
        ], [], [ 
            'username' => 'Username',
            'password' => 'Password',
        ]);

        if($validator->fails()) {
            $this->validationError($validator);
        }

        // Check Login Attempts
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());

            return $this->errorResponse('Authentication Failed', trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]));
        }

        // Check User Authentication
        if (!Auth::once(['username'  => $request->username, 'password'  => $request->password])) {
            RateLimiter::hit($this->throttleKey());

            return $this->errorResponse('Authentication Failed', __('auth.failed'));
        }

        $authUser = Auth::user();

        // Delete existing authentication
        UserAuthenticate::where('user_uniq_id', $authUser->uniq_id)->delete();

        // Insert/Update user authentication
        $saveData = [
            'user_uniq_id' => $authUser->uniq_id,
            'token'        => Str::random(64),
            'code'         => Str::substr(str_shuffle("123456789"), 0, 6),
            'expired_at'   => date('Y-m-d H:i:s', strtotime('+30 minutes')),
            'created_at'   => date('Y-m-d H:i:s')
        ];

        UserAuthenticate::create($saveData);

        RateLimiter::clear($this->throttleKey());

        return $this->successResponse('Authenticate successful', [
            'token'  => $saveData['token'],
            'email'  => Str::mask($authUser->email, '*', -16, 5),
            'mobile' => Str::mask($authUser->mobile_no, '*', 0, 9)
        ]);
    }

    /**
     * Validation authentication code
     */

    public function validate_auth(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->only('token', 'code'), [
            'token' => ['required', 'string', 'min:5'],
            'code'  => ['required', 'string', 'min:6', 'max:6'],
        ], [], [ 
            'token' => 'Token',
            'code'  => 'OTP Code',
        ]);

        if($validator->fails()) {
            $this->validationError($validator);
        }

        // Check request token
        $authUser = UserAuthenticate::where('token', $request->token)->first();

        if(is_null($authUser)) {
            return $this->errorResponse('Authentication Failed!', 'Invalid authentication request.');
        }

        // if((int) $authUser->code != (int) $request->code) {
        //     return $this->errorResponse('Authentication Failed!', 'One-Time Password (OTP) is invalid.');
        // }

        if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($authUser->expired_at))) {
            return $this->errorResponse('Authentication Failed!', 'Your authentication request is expired.');
        }

        // Get user data for session data
        $userData = User::where('uniq_id', '=', $authUser->user_uniq_id)->first();

        Auth::loginUsingId($userData->id);

        return $this->successResponse('User credential was successfully authenticated.');
    }

    /**
     * Send One-Time Password using smtp and sms
     */

    public function send_code(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->only('token', 'auth_opt'), [
                'token'    => ['required', 'string', 'min:5'],
                'auth_opt' => ['required', 'string', 'min:4', 'max:4'],
            ], [], [ 
                'token'    => 'Token',
                'auth_opt' => 'Authentication option',
            ]);
    
            if($validator->fails()) {
                $this->validationError($validator);
            }
    
            // Check authentication token
            $authUser = UserAuthenticate::join('users', 'user_authenticates.user_uniq_id', '=', 'users.uniq_id')
                            ->where('token', $request->token)
                            ->first([ 
                                'user_authenticates.*', 
                                'users.uniq_id',
                                'users.firstname', 
                                'users.lastname', 
                                'users.email', 
                                'users.mobile_no' 
                            ]);
    
            if(is_null($authUser)) {
                return $this->errorResponse('Request Failed!', 'Invalid authentication request.');
            }
    
            if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($authUser->expired_at))) {
                return $this->errorResponse('Authentication Failed!', 'Your authentication request is expired.');
            }
    
            // Update authentication code
            $otpCode = Str::substr(str_shuffle("123456789"), 0, 6);
            UserAuthenticate::where('user_uniq_id', $authUser->uniq_id)
                ->update(['code' => $otpCode]);
    
            // if($request->auth_opt == 'sms') {
    
            // }
            // else if($request->auth_opt == 'smtp') {
    
            // }
    
            $receiverName = $authUser->firstname . ' ' . $authUser->lastname;
    
            // Mail::to($authUser->email)->send(new AuthenticationMail($receiverName, $otpCode));
    
            return $this->successResponse('One-Time Password (OTP) was successfully sent.');
        }
        catch(\Exception $e) {
            return $this->errorResponse('Processing Failed!', $e->getMessage());
        }
    }

    /**
     * Logout session
     */
    
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower(request()->input('username')).'|'.request()->ip());
    }
}
