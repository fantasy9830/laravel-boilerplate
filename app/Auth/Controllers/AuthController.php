<?php

namespace App\Auth\Controllers;

use ApiAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // Authenticating against LDAP server.
        if (ApiAuth::login($username, $password)) {
            // Passed!
            $token = ApiAuth::createToken($username);

            return response()->json(['token' => $token]);
        } else {
            return abort(401, 'Username or password is incorrect.');
        }
    }
}
