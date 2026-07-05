<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Marketing Settings
    |--------------------------------------------------------------------------
    */

    'name' => 'Marketing',

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    */
    'themes' => [
        'obsidian' => [
            'name'  => 'Obsidian Dark',
            'class' => 'theme-obsidian',
            'icon'  => 'bi-moon-stars-fill'
        ],
        'cyber' => [
            'name'  => 'Cyber Neon Blue',
            'class' => 'theme-cyber',
            'icon'  => 'bi-cpu-fill'
        ],
        'astral' => [
            'name'  => 'Astral Purple Glass',
            'class' => 'theme-astral',
            'icon'  => 'bi-activity'
        ],
        'minimal' => [
            'name'  => 'Minimalist Light',
            'class' => 'theme-minimal',
            'icon'  => 'bi-sun-fill'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Selected Theme
    |--------------------------------------------------------------------------
    */
    'default_theme' => 'obsidian',

    /*
    |--------------------------------------------------------------------------
    | Pricing Packages List
    |--------------------------------------------------------------------------
    */
    'pricing' => [
        [
            'name'        => 'Free Starter',
            'price'       => '0',
            'period'      => 'month',
            'description' => 'For hobbyists and individual developers starting out.',
            'features'    => [
                '1 User Workspace',
                'Basic Modules Integration',
                'Local SQLite Database support',
                'Standard community forum access',
            ],
            'button'      => 'Get Started',
            'route'       => 'auth.register',
            'popular'     => false,
        ],
        [
            'name'        => 'Growth Pro',
            'price'       => '29',
            'period'      => 'month',
            'description' => 'For growing teams requiring robust SaaS orchestration.',
            'features'    => [
                'Up to 10 Team Members',
                'Unlimited Custom Module builds',
                'PostgreSQL / MySQL support',
                'Advanced 2FA Account protection',
                'Email and Slack priority support',
            ],
            'button'      => 'Start 14-Day Free Trial',
            'route'       => 'auth.register',
            'popular'     => true,
        ],
        [
            'name'        => 'Enterprise Scale',
            'price'       => '149',
            'period'      => 'month',
            'description' => 'Custom modules, robust safety features, scaling infrastructure.',
            'features'    => [
                'Unlimited Workspaces & Teams',
                'Tenant isolation & SLA guarantees',
                'Dedicated database cluster options',
                'Custom SSO / SAML integration',
                '24/7 Phone & video call support',
            ],
            'button'      => 'Contact Sales',
            'route'       => 'marketing.contact',
            'popular'     => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Key Application Features
    |--------------------------------------------------------------------------
    */
    'features' => [
        [
            'icon'  => 'bi-box-seam',
            'title' => 'Dynamic Module Builder',
            'desc'  => 'Create tables, relationships, controllers, and premium Blade forms dynamically in one click.'
        ],
        [
            'icon'  => 'bi-shield-check',
            'title' => 'SaaS Authentication & 2FA',
            'desc'  => 'Enterprise-grade user auth, login history logs, profile dashboards, and automated email verifications.'
        ],
        [
            'icon'  => 'bi-hdd-network',
            'title' => 'Multi-Tenant Isolation',
            'desc'  => 'Database scope isolation via tenant_id constraints to secure SaaS workspaces out of the box.'
        ],
        [
            'icon'  => 'bi-lightning-charge',
            'title' => 'Async Queue Pipeline',
            'desc'  => 'Job backoffs, event listeners, and welcome notify emails running asynchronously in background queues.'
        ],
    ],

];
