<?php

namespace App\Http\Controllers;
use App\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Created by PhpStorm.
 * User: Son Nguyen
 * Date: 9/1/2018
 * Time: 3:58 PM
 */
class LoginController extends Controller implements JWTSubject
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if(!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or password doesn\'t exist'],401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
    }
}



