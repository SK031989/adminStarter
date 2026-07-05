<?php

use Illuminate\Support\Facades\Artisan;
use Modules\Auth\App\Models\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('auth:list-users', function () {
    $users = User::all(['id', 'name', 'email', 'status', 'is_admin', 'created_at']);

    $this->table(
        ['ID', 'Name', 'Email', 'Status', 'Admin', 'Created At'],
        $users->map(fn ($user) => [
            $user->id,
            $user->name,
            $user->email,
            $user->status->label(),
            $user->is_admin ? 'Yes' : 'No',
            $user->created_at?->toDateTimeString(),
        ])->toArray()
    );
})->purpose('List all registered users inside database');

Artisan::command('auth:create-admin {name} {email} {password}', function (string $name, string $email, string $password) {
    $this->info("Creating Admin User: {$name} <{$email}>...");

    $user = User::create([
        'tenant_id'          => 1,
        'name'               => $name,
        'email'              => $email,
        'password'           => \Illuminate\Support\Facades\Hash::make($password),
        'status'             => \Modules\Auth\App\Enums\UserStatusEnum::Active,
        'is_admin'           => true,
        'email_verified_at'  => now(),
    ]);

    $this->info("Admin User [{$user->name}] created successfully with ID: {$user->id}!");
})->purpose('Create a new admin user');
