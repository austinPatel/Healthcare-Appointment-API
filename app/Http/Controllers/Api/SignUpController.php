<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use Exception;

class SignUpController extends ApiController
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /*
        User Register
    */
    public function register(UserRequest $request)
    {
        try {
            $user = $this->userRepository->requestUser($request->all());
            $token = $user->createToken('token')->accessToken;
            $response = [
                'token' => $token,
                'user' => $user
            ];
            return $this->sendResponse($response, 'User Successfully register');
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

}
