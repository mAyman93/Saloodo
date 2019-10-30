<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Admin;

class AuthController extends Controller
{
    protected $usersModel;
    protected $adminsModel;

    public function __construct(User $users, Admin $admins)
    {
        $this->usersModel = $users;
        $this->adminsModel = $admins;
    }

    public function login(Request $request)
    {
        if(!$this->validateRequestPayload($request)) {
            return response()->json(['error' => 'invalid inputs'], 400);
        }
        $credentials = $request->only('email', 'password');
        return $this->usersModel->login($credentials);
    }

    public function adminLogin(Request $request)
    {
        if(!$this->validateRequestPayload($request)) {
            return response()->json(['error' => 'invalid inputs'], 400);
        }
        $credentials = $request->only('email', 'password');
        return $this->adminsModel->login($credentials);
    }

    public function validateRequestPayload($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return false;
        }
        return true;
    }
}
