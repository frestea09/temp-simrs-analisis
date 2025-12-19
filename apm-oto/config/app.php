<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'RSUD OTISTA BANDUNG'), 
	'merek' => ('SIMRS TERINTEGRASI'),
	'nama' => ('RSUD OTISTA BANDUNG'),
	'nama_rs' => ('RSUD OTISTA BANDUNG'),
	'nama_kop' =>('RSUD OTISTA BANDUNG'),
	'nama_kop_rs' =>('RSUD OTISTA BANDUNG'),
	'alamat_kop' => ('Jalan Raya Gading Tutuka, RT.01/RW.01, Kampung Cincin Kolot, Kec. Soreang, Kabupaten Bandung, Jawa Barat '),
	'fax' => '0763 – 32004',
    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg/1229px-Lambang_Kabupaten_Bandung%2C_Jawa_Barat%2C_Indonesia.svg.png',
	'alamat' => ('Jalan Raya Gading Tutuka'),
	'kota' => ('Kabupaten Bandung'),
	'developer' => ('SIMRS'),
	'no_rm' => 769695,
	'obatRacikan_id' => '2140',
	'tuslah' => '2141',
	'uang_racik' => '4000',
	'coder_nik' => '123123123123',
    // OTISTA
	// 'sep_id' => '28210',
	// 'sep_key' => '9iM79B1954',
	// // 'sep_url_web_service' => 'https://apijkn.bpjs-kesehatan.go.id/vclaim-rest',
	// 'sep_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev',
	// 'sep_ppkLayanan' => '1002R006',
	// 'user_key' => '1567f40dd40a341b3e7578a0d4f36862',
    'sep_id' => '18007',
	'sep_key' => '3uQWDs2243',
	'sep_url_web_service' => 'https://new-apijkn.bpjs-kesehatan.go.id/vclaim-rest',
	// 'sep_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev',
	'sep_ppkLayanan' => '1002R006',
	'user_key' => '25009c91bcbbf0450895669ef3a7e177',

    //Setting Eklaim
    'tipe_RS' => 'CS',
    'keyRS' => 'e78aa7304674868c5d813c004aa0c3b3721169d75c858fe7c27542c89d548e3f',
    'url_eklaim' => 'http://192.168.1.79/E-Klaim/ws.php',

    // ANTREAN PROD
	// 'consid_antrean' => '28210',
	// 'secretkey_antrean'=>'9iM79B1954',
	// 'user_key_antrean'=>'85fd24c1152f78c8a0973e7f722ffeee',
	// // 'antrean_url_web_service' => 'https://apijkn.bpjs-kesehatan.go.id/antreanrs/',
	// 'antrean_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/',
    // 'consid_antrean' => '18007',
	// 'secretkey_antrean'=>'3uQWDs2207',
	// 'user_key_antrean'=>'2a07dab4dbf66725329d4890966d6457',
	// 'antrean_url_web_service' => 'https://apijkn.bpjs-kesehatan.go.id/antreanrs/',
    'consid_antrean' => '18007',
	'secretkey_antrean' => '3uQWDs2243',
	'user_key_antrean' => '2a07dab4dbf66725329d4890966d6457',
	// 'antrean_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/',
	// 'antrean_url_web_service' => 'https://new-apijkn.bpjs-kesehatan.go.id/antreanrs_dev/',
	'antrean_url_web_service' => 'https://new-apijkn.bpjs-kesehatan.go.id/antreanrs/',
    
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

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

    'debug' => env('APP_DEBUG', false),

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

    'url' => env('APP_URL', 'http://localhost'),

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

    'timezone' => 'Asia/Jakarta',

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

    'locale' => 'id',

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

    'fallback_locale' => 'id',

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

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

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

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

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
        Collective\Html\HtmlServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

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
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Form' => Collective\Html\FormFacde::class,
        'Html' => Collective\Html\HtmlFacde::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,

    ],

];
