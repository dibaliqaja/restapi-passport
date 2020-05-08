<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register API.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'email'             => 'required|email',
            'password'          => 'required',
            'password_confirm'  => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input              = $request->all();
        $user               = User::create($input);
        $input['password']  = bcrypt($input['password']);
        $success['token']   = $user->createToken('MyApp')->accessToken;
        $success['name']    = $user->name;

        return $this->sendResponse($success, 'User Register Successfully.');
    }

    /**
     * Login API.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user               = Auth::user();
            $success['token']   = $user->createToken('MyApp')->accessToken;
            $success['name']    = $user->name;

            return $this->sendResponse($success, 'User Login Succesfully.');
        }

        return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
    }
}
