<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class CustomTokenGuard implements Guard
{
    use GuardHelpers;

    protected $request;

    public function __construct($userProvider, Request $request)
    {
        $this->provider = $userProvider;
        $this->request = $request;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $token = $this->getTokenForRequest();

        if (empty($token)) {
            return null;
        }

        // User the custom 'token' column instead of 'api_token'
        $user = $this->provider->retrieveByToken($token, 'token');

        return $this->user = $user;
    }

    public function getTokenForRequest()
    {
        $token = $this->request->query('token');

        if (empty($token)) {
            $token = $this->request->input('token');
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    public function validate(array $credentials = [])
    {
        if (empty($credentials['token'])) {
            return false;
        }

        $user = $this->provider->retrieveByToken($credentials['token'], 'token');

        if (!is_null($user)) {
            $this->setUser($user);

            return true;
        }

        return false;
    }
}