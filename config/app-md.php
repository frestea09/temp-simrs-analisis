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

	'name' => env('APP_NAME', 'RSU ST MADYANG'),
	'nama' => ('RSU ST MADYANG'),
	'merek' => ('SIMRS TERINTEGRASI'),
	'nama' => ('RSU ST.MADYANG'),
	'alamat' => ('Jl. Andi Kambo No.87, Kota Palopo, 0471-24227'),
	'kota' => ('Kota Palopo'),
	'developer' => ('digiHealth Indonesia'),
	'no_rm' => 51690,
	'obatRacikan_id' => '2140',
	'tuslah' => '2141',
	'uang_racik' => '4000',

	'sep_id' => '5839',
	'sep_key' => '2oV8E31D56',
	'sep_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev',
	'sep_ppkLayanan' => '0237R004', 
	'user_key'=>'61b53b1a81ca57a06f786155b6ffe99a',

	'username_ws' => 'rsiatg',
	'password_ws' => 'r5iatg@2022',
	// STMADYANG
	// 'sep_id' => '5839',
	// 'sep_key' => '2oV8E31D56',
	// 'sep_url_web_service' => 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev',
	// 'sep_ppkLayanan' => '0237R004', 
	'user_key'=>'61b53b1a81ca57a06f786155b6ffe99a',

	// 'sep_id' => '6457',
	// 'sep_key' => '0wAA69E119',
	// 'sep_url_web_service' => 'https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest',
	// 'sep_ppkLayanan' => '0237R004',
	
	//Setting Eklaim
	'tipe_RS' => 'DS',
	'keyRS' => '146c0b06f65646260f56b5425a34b1376594806cfe3eb987c3f1048e4f37f7b4',
	'url_eklaim' => 'http://192.168.1.212/E-Klaim/ws.php',

	// User untuk hapus opname
	'user_gudang' => 140, // fitrah@sim.rs
	'user_farmasi' => 157, // fatur@sim.rs
	//=========================================================================

	// MANDIRI INHEALTH
	// 'base_url_inhealth' => "http://development.inhealth.co.id/pelkesws2/api/",
	// 'token_inhealth' => "inh_a8ceb8eb4d8ee3ba09370bc473dbe31d",
	// 'username_inhealth' => "user.testing",
	// 'kodeprovider_inhealth' => '1824R007',
	// production
	'base_url_inhealth' => "https://app.inhealth.co.id/pelkesws2/api/",
	'token_inhealth' => "inh_505df7bd26a0179c7fae4aac25d4c0b3",
	'username_inhealth' => "1824r007.ima",
	'kodeprovider_inhealth' => '1824R007',
	// END MANDIRI INHEALTH

	'covid_base_url' => 'http://sirs.kemkes.go.id/fo/index.php/',
    'covid_rs_id' => '7373004',
    'covid_rs_pass' => 'S!rs2020!!',
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
		Collective\Html\HtmlServiceProvider::class,
		Nwidart\Modules\LaravelModulesServiceProvider::class,
		Intervention\Image\ImageServiceProvider::class,
		MercurySeries\Flashy\FlashyServiceProvider::class,
		Maatwebsite\Excel\ExcelServiceProvider::class,
		Milon\Barcode\BarcodeServiceProvider::class,
		Yajra\DataTables\DataTablesServiceProvider::class,
		Backup\BackupServiceProvider::class,
		Unisharp\Ckeditor\ServiceProvider::class,
		Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider::class,
		Barryvdh\DomPDF\ServiceProvider::class,
		Spatie\Activitylog\ActivitylogServiceProvider::class,
		Gloudemans\Shoppingcart\ShoppingcartServiceProvider::class,

		/*
			         * Application Service Providers...
		*/
		App\Providers\AppServiceProvider::class,
		App\Providers\AuthServiceProvider::class,
		// App\Providers\BroadcastServiceProvider::class,
		App\Providers\EventServiceProvider::class,
		App\Providers\RouteServiceProvider::class,
		PrettyRoutes\ServiceProvider::class,

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
		'Form' => Collective\Html\FormFacade::class,
		'Html' => Collective\Html\HtmlFacade::class,
		'Module' => Nwidart\Modules\Facades\Module::class,
		'Image' => Intervention\Image\Facades\Image::class,
		'Flashy' => MercurySeries\Flashy\Flashy::class,
		'Excel' => Maatwebsite\Excel\Facades\Excel::class,
		'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
		'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
		'DataTables' => Yajra\DataTables\Facades\DataTables::class,
		'PDF' => Barryvdh\DomPDF\Facade::class,
		'Activity' => Spatie\Activitylog\ActivitylogFacade::class,
		'Cart' => Gloudemans\Shoppingcart\Facades\Cart::class,
	],

];
