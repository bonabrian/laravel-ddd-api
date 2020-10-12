<?php

namespace App\Domain\Users\Database\Factories;

use App\Domain\Users\Entities\User;
use App\Infrastructure\Abstracts\ModelFactory;

class UserFactory extends ModelFactory
{
    protected string $model = User::class;

    public function fields()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('secretxxx'),
            'is_active' => true,
            'email_verified_at' => now(),
            'locale' => 'id_ID'
        ];
    }

    public function states()
    {
        $this->factory->state($this->model, 'active', function () {
            return [
                'is_active' => true
            ];
        });

        $this->factory->state($this->model, 'inactive', function () {
            return [
                'is_active' => false
            ];
        });

        $this->factory->state($this->model, 'email_verified', function () {
            return [
                'email_verified_at' => now()->format('Y-m-d H:i:s')
            ];
        });

        $this->factory->state($this->model, 'email_unverified', function () {
            return [
                'email_verified_at' => null
            ];
        });

        $this->factory->state($this->model, 'phone_verified', function () {
            return [
                'phone_verified_at' => now()->format('Y-m-d H:i:s')
            ];
        });

        $this->factory->state($this->model, 'phone_unverified', function () {
            return [
                'phone_verified_at' => null
            ];
        });
    }
}
