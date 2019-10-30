<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JWTAuth;

class Admin extends User
{
    public function login($credentials)
    {
        $encryptedPassword = bcrypt($credentials['password'] . 'tasty salt');
        $credentials['password'] = $encryptedPassword;
        $admin = User::where('email', $credentials['email'])
                    ->where('password', $encryptedPassword)
                    ->join('admins', 'admins.user_id', '=', 'users.id');
        if(!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
        $token = JWTAuth::fromUser($admin, ['admin' => 1]);
        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }
}
