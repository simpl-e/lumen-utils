<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

/* LOAD COMPOSER */
require_once __DIR__ . '/../vendor/autoload.php';

/* LOAD .env */
(new Dotenv\Dotenv(__DIR__ . '/../'))->load();

/* START LUMEN */
$app = new Laravel\Lumen\Application(
        realpath(__DIR__ . '/../')
);

/* ADD ELOQUENT */
$app->withFacades(true, [
    Tymon\JWTAuth\Facades\JWTAuth::class => 'JWTAuth',
    Tymon\JWTAuth\Facades\JWTFactory::class => 'JWTFactory'
]);
$app->withEloquent();

$app->configure('broadcasting');

/* JWT AUTHENTIFICATION */
//https://github.com/tymondesigns/jwt-auth/issues/1102#issuecomment-296712123
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
/* WEBSOCKET */
$app->register(\Illuminate\Redis\RedisServiceProvider::class);
$app->register(App\Providers\BroadcastServiceProvider::class); //(Broadcast routes)


$app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class, Laravel\Lumen\Exceptions\Handler::class
);
$app->singleton(
        Illuminate\Contracts\Console\Kernel::class, Laravel\Lumen\Console\Kernel::class
);

/* MIDDLEWARES */
$app->routeMiddleware([
    'jwt-auth' => App\Http\Middleware\Authenticate::class,
]);

//use Auth;
$app->router->group(['middleware' => 'jwt-auth'], function($router) {
    $router->post('/broadcasting/auth', function(Illuminate\Http\Request $request) {
        Illuminate\Support\Facades\Broadcast::auth($request);
    });
});

$app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
    require __DIR__ . '/../routes/api.php';
});

/* RUN */
return $app;
