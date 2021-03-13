<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;

        return $this->sendResponse($success, 'User register successfully.');
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $success['token'] = $user->createToken('appToken')->accessToken;
            $success['user'] = $user;

            return $this->sendResponse($success, 'User login successfully.');
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }


    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return $this->sendResponse([], 'User logout successfully.');
    }

    public function getMe()
    {
        $user = Auth::user();
        $success['user'] = $user;
        return $this->sendResponse($success, '');
    }
}
