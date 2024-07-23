<?php

namespace App\Http\Controllers;

use App\Helpers\Result;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private Result $result
    ) {
    }

    public function login(UserRequest $request)
    {
        if (auth('web')->attempt($request->validated())) {
            $user = auth('web')->user();
            return new UserResource($user);
        } else return $this->result->error(__('Invalid login or password'));
    }

    public function logout()
    {
        auth('web')->logout();
        return $this->result->success(__('Successfully logged out'));
    }
}
