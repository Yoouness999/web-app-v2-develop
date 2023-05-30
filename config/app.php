<?php

# Imported from _config.php
global $_config;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'env' => env('APP_ENV', 'production'),

    'debug' => env('APP_DEBUG', false),

    'boxify_project_folder' => env('APP_BOXIFY_PROJECT_FOLDER', '/home/boxify/web/staging/public'),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => ROOT_URL,

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Europe/Brussels',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => ZE_LANG,

    'locales' => [
        'fr' => [
            'url'    => $_config['locales_url']['fr'],
            'active' => false,
            'name'   => 'French',
        ],
        'nl' => [
            'url'    => $_config['locales_url']['nl'],
            'active' => false,
            'name'   => 'Dutch',
        ],
        'en' => [
            'url'    => $_config['locales_url']['en'],
            'active' => true,
            'name'   => 'English',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'GTNHLvXA9UYe3KH8kHXtBnkWTLl9dbMT'),

    'cipher' => "AES-256-CBC",

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => 'daily',

    "editor" => "phpstorm",

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Broadcasting\BroadcastServiceProvider',
        \Collective\Html\HtmlServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,

        /*
         * Arx Service Providers...
         */
        //'Arx\CoreServiceProvider',
        //'Arxmin\ArxminServiceProvider',

        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider',
        'App\Providers\ConfigServiceProvider',
        'App\Providers\EventServiceProvider',
        'App\Providers\RouteServiceProvider',
		'App\Providers\AdyenServiceProvider',
        'App\Providers\MailchimpServiceProvider',
        'App\Providers\PaymentNotificationServiceProvider',

        /**
         * Third-partys
         */
        'Laravel\Socialite\SocialiteServiceProvider',
        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        \Modules\Labelmanager\Providers\LabelmanagerServiceProvider::class,
        \Modules\Datamanager\Providers\DatamanagerServiceProvider::class,

        // @see https://github.com/Propaganistas/Laravel-Phone
        Propaganistas\LaravelPhone\PhoneServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => 'Illuminate\Support\Facades\App',
        'Artisan'   => 'Illuminate\Support\Facades\Artisan',
        'Auth'      => 'Illuminate\Support\Facades\Auth',
        'Blade'     => 'Illuminate\Support\Facades\Blade',
        'Bus'       => 'Illuminate\Support\Facades\Bus',
        'Cache'     => 'Illuminate\Support\Facades\Cache',
        'Config'    => 'Illuminate\Support\Facades\Config',
        'Cookie'    => 'Illuminate\Support\Facades\Cookie',
        'Crypt'     => 'Illuminate\Support\Facades\Crypt',
        'DB'        => 'Illuminate\Support\Facades\DB',
        'Eloquent'  => 'Illuminate\Database\Eloquent\Model',
        'Event'     => 'Illuminate\Support\Facades\Event',
        'File'      => 'Illuminate\Support\Facades\File',
        'Hash'      => 'Illuminate\Support\Facades\Hash',
        'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'Lang'      => 'Illuminate\Support\Facades\Lang',
        'Log'       => 'Illuminate\Support\Facades\Log',
        'Mail'      => 'Illuminate\Support\Facades\Mail',
        'Password'  => 'Illuminate\Support\Facades\Password',
        'Queue'     => 'Illuminate\Support\Facades\Queue',
        'Redirect'  => 'Illuminate\Support\Facades\Redirect',
        'Redis'     => 'Illuminate\Support\Facades\Redis',
        'Request'   => 'Illuminate\Support\Facades\Request',
        'Response'  => 'Illuminate\Support\Facades\Response',
        'Route'     => 'Illuminate\Support\Facades\Route',
        'Schema'    => 'Illuminate\Support\Facades\Schema',
        'Session'   => 'Illuminate\Support\Facades\Session',
        'Storage'   => 'Illuminate\Support\Facades\Storage',
        'URL'       => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator',
        'Gate' => "Illuminate\Support\Facades\Gate",
        'Notification' => Illuminate\Support\Facades\Notification::class,

        'Controller' => 'Illuminate\Routing\Controller',
        'HTML' => \Collective\Html\HtmlFacade::class,
        'Form' => \Collective\Html\FormFacade::class,

        # Arx aliases
        'View'      => \Illuminate\Support\Facades\View::class,
        'Asset' => 'Arx\classes\Asset',
        'Shortcode' => \Blok\Shortcode\Facades\Shortcode::class,
        'Arr' => Blok\Utils\Arr::class,
        "Hook" => "Blok\\LaravelHook\\Hook",
        //'Dummy' => 'Arx\classes\Dummy',
        //'Utils' => 'Arx\classes\Utils',
        'Arxmin' => 'Arxmin\Arxmin',
        'FormHelper' => 'Arxmin\helpers\FormHelper',
        'Socialite' => \Laravel\Socialite\Facades\Socialite::class,

        # Module aliases
        'Label' => \App\Label::class
    ],

	/*
    |--------------------------------------------------------------------------
    | Google Api Key
    |--------------------------------------------------------------------------
    |
    */

	'google' => [
		'places' => env('GOOGLE_API_KEY', 'AIzaSyCIjc3NxG65UPljS1GZXAl83XyZWf1HGKg'),
	],

	/*
    |--------------------------------------------------------------------------
    | Boxify Api
    |--------------------------------------------------------------------------
    |
    */

	'boxify_api' => [
		'token_lifetime' => [
			'request' => 60 * 6, // 6h
			'access_client' => 60 * 6, // 6h
			'access_transporter' => 60 * 14, // 14h
			'refresh' => 60 * 24 * 90 // 90d
		],
		'max_deep' => 1,
	],

];
