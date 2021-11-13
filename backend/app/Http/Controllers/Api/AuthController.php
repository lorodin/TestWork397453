<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $input = $request->validated();

        if(!Auth::attempt(['email' => $input['email'], 'password' => $input['password']])){
            return $this->jsonResponse(false, 'Incorrect email or password');
        }

        /**
         * @var User $user
         */
        $user = Auth::user();

        return $this->jsonResponse(true, [
            'token' => $user->createToken('Laravel')->accessToken
        ]);
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->validated();

        $user = new User;

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);

        $user->save();

        if (!$user->save()) {
            return $this->jsonResponse(false, 'Unknown error', 400);
        }

        return $this->jsonResponse(true, [
            'token' => $user->createToken('MyApp')->accessToken
        ]);
    }
}
