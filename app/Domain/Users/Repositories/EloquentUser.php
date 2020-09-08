<?php

/**
 * @author Bona Brian Siagian <bonabriansiagian@gmail.com>
 */

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Contracts\UserRepository;
use App\Infrastructure\Abstracts\EloquentRepository;

class EloquentUser extends EloquentRepository implements UserRepository
{
    /**
     * Define model for this repository.
     */
    public function model()
    {
        return \App\Domain\Users\Entities\User::class;
    }
}
