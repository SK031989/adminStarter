<?php

namespace Modules\Auth\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'tenant_id'          => 1,
            'name'               => $this->faker->name(),
            'email'              => $this->faker->unique()->safeEmail(),
            'email_verified_at'  => now(),
            'password'           => Hash::make('Password123!'),
            'phone'              => $this->faker->phoneNumber(),
            'avatar'             => null,
            'status'             => UserStatusEnum::Active->value,
            'is_admin'           => false,
            'two_factor_secret'   => null,
            'two_factor_enabled'  => false,
            'remember_token'     => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'status'            => UserStatusEnum::Pending->value,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatusEnum::Suspended->value,
        ]);
    }
}
