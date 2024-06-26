<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'fulfillment' => [
            'driver' => 'session',
            'provider' => 'fulfillment',
        ],

        'account' => [
            'driver' => 'session',
            'provider' => 'accounts',
        ],

        'fleet' => [
            'driver' => 'session',
            'provider' => 'fleets',
        ],

        'support' => [
            'driver' => 'session',
            'provider' => 'support',
        ],

        'return' => [
            'driver' => 'session',
            'provider' => 'return',
        ],
        
        'dispatcher' => [
            'driver' => 'session',
            'provider' => 'dispatcher',
        ],

        'cms' => [
            'driver' => 'session',
            'provider' => 'cms',
        ],
        
        'crm' => [
            'driver' => 'session',
            'provider' => 'crm',
        ],

        'provider' => [
            'driver' => 'session',
            'provider' => 'providers',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],

        'providerapi' => [
            'driver' => 'jwt',
            'provider' => 'providers',
        ],

        'bm' => [
            'driver' => 'session',
            'provider' => 'bm',
        ],
        'sortcenter' => [
            'driver' => 'session',
            'provider' => 'sortcenter',
        ],
        'pickup' => [
            'driver' => 'session',
            'provider' => 'pickup',
        ],
        'dispatcherapi' => [
            'driver' => 'passport',
            'provider' => 'dispatcher',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'fulfillment' => [
            'driver' => 'eloquent',
            'model' => App\Dispatcher::class,
        ],

        'accounts' => [
            'driver' => 'eloquent',
            'model' => App\Account::class,
        ],

        'fleets' => [
            'driver' => 'eloquent',
            'model' => App\Fleet::class,
        ],
        'support' => [
            'driver' => 'eloquent',
            'model' => App\SupportUser::class,
        ],

        'return' => [
            'driver' => 'eloquent',
            'model' => App\ReturnUser::class,
        ],

        'accounts' => [
            'driver' => 'eloquent',
            'model' => App\Account::class,
        ],

        'fleets' => [
            'driver' => 'eloquent',
            'model' => App\Fleet::class,
        ],

        'cms' => [
            'driver' => 'eloquent',
            'model' => App\CmsUser::class,
        ],
        
        'crm' => [
            'driver' => 'eloquent',
            'model' => App\CrmUser::class,
        ],
        'dispatcher' => [
            'driver' => 'eloquent',
            'model' => App\Dispatcher::class,
        ],
        // 'dispatchers' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Dispatcher::class,
        // ],
        'providers' => [
            'driver' => 'eloquent',
            'model' => App\Provider::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],

        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'bm' => [
            'driver' => 'eloquent',
            'model' => App\BranchManager::class,
        ],
        'sortcenter' => [
            'driver' => 'eloquent',
            'model' => App\Model\SortCenterUser::class,
        ],   
        'pickup' => [
            'driver' => 'eloquent',
            'model' => App\Model\PickupUser::class,
        ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'accounts' => [
            'provider' => 'accounts',
            'table' => 'account_password_resets',
            'expire' => 60,
        ],
        'fleets' => [
            'provider' => 'fleets',
            'table' => 'fleet_password_resets',
            'expire' => 60,
        ],
        'crm' => [
            'provider' => 'crm',
            'table' => 'crm_password_resets',
            'expire' => 60,
        ],
        'cms' => [
            'driver' => 'cms',
            'table' => 'cms_password_resets',
            'expire' => 60,
        ],
        
        'crm' => [
            'driver' => 'crm',
            'table' => 'crm_password_resets',
            'expire' => 60,
        ],

        'fleets' => [
            'driver' => 'eloquent',
            'model' => App\Fleet::class,
        ],

        // 'dispatchers' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Dispatcher::class,
        // ],
        
        'providers' => [
            'provider' => 'providers',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'dispatcher' => [
            'provider' => 'dispatcher',
            'table' => 'dispatcher_password_resets',
            'expire' => 60,
        ],
        'bm' => [
            'driver' => 'bm',
            'table' => 'bm_password_resets',
            'expire' => 60,
        ],
        'support' => [
            'driver' => 'support',
            'table' => 'support_password_resets',
            'expire' => 60,
        ],
        'return' => [
            'driver' => 'return',
            'table' => 'return_password_resets',
            'expire' => 60,
        ],
        'sortcenter' => [
            'driver' => 'sortcenter',
            'table' => 'sortcenter_password_resets',
        ],
        'pickup' => [
            'driver' => 'pickup',
            'table' => 'pickup_password_resets',
            'expire' => 60,
         ],
        ],

];
