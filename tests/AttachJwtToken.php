<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use JWTAuth;

trait AttachJwtToken
{
    /**
     * @var \App\Domain\Users\Entities\User
     */
    protected $loginUser;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param null $driver
     *
     * @return $this
     */
    public function actingAs(Authenticatable $user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }
}
