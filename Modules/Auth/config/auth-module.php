<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Name
    |--------------------------------------------------------------------------
    */
    'name' => 'Auth',

    /*
    |--------------------------------------------------------------------------
    | Module enabled flag
    |--------------------------------------------------------------------------
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Registration Settings
    |--------------------------------------------------------------------------
    */
    'registration' => [
        'enabled'           => env('AUTH_REGISTRATION_ENABLED', true),
        'email_verification' => env('AUTH_EMAIL_VERIFICATION', true),
        'auto_login'        => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Settings
    |--------------------------------------------------------------------------
    */
    'password' => [
        'min_length'      => 8,
        'require_uppercase' => true,
        'require_number'    => true,
        'require_symbol'    => false,
        'reset_expiry'      => 60, // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Authentication
    |--------------------------------------------------------------------------
    */
    'two_factor' => [
        'enabled'   => env('AUTH_2FA_ENABLED', false),
        'issuer'    => env('APP_NAME', 'SaaS App'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Settings
    |--------------------------------------------------------------------------
    */
    'session' => [
        'lifetime'        => env('SESSION_LIFETIME', 120),
        'remember_days'   => 30,
        'track_activity'  => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth / Social Login (add providers as needed)
    |--------------------------------------------------------------------------
    */
    'social' => [
        'enabled'   => env('AUTH_SOCIAL_ENABLED', false),
        'providers' => ['google', 'github'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Throttling
    |--------------------------------------------------------------------------
    */
    'throttle' => [
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect Paths
    |--------------------------------------------------------------------------
    */
    'redirects' => [
        'login'        => '/dashboard',
        'logout'       => '/auth/login',
        'register'     => '/dashboard',
        'verified'     => '/dashboard',
    ],

    /*
    |--------------------------------------------------------------------------
    | SaaS Tenant Binding
    |--------------------------------------------------------------------------
    | Automatically bind user to a tenant on registration.
    */
    'tenant' => [
        'auto_create'       => env('AUTH_AUTO_CREATE_TENANT', true),
        'default_plan'      => env('AUTH_DEFAULT_PLAN', 'trial'),
        'trial_days'        => env('AUTH_TRIAL_DAYS', 14),
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue for async notifications
    |--------------------------------------------------------------------------
    */
    'queue_connection' => env('AUTH_QUEUE', 'sync'),
    'queue_name'       => env('AUTH_QUEUE_NAME', 'auth-notifications'),

];
