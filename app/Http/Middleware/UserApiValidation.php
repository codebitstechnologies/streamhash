<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use Validator;

use Log;

use App\User;

use DB;

class UserApiValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $validator = Validator::make(
                $request->all(),
                array(
                        'token' => 'required|min:5',
                        'id' => 'required|integer|exists:users,id'
                ));

        if ($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());

            $response = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

            return response()->json($response,200);

        } else {

            $token = $request->token;

            $user_id = $request->id;

            if (!Helper::is_token_valid('USER', $user_id, $token, $error)) {

                $response = response()->json($error, 200);
                return $response;
            } else {
                $user = User::find($request->id);

                if(!$user) {
                    
                    $response = array('success' => false , 'error' => Helper::get_error_message(133) , 'error_code' => 133);
                    return response()->json($response, 200);
                }
            }
        }

        return $next($request);
    }
}
