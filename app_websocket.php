<?php

class Application extends Laravel\Lumen\Application {

    public function routesAreCached() {
        return false;
    }

}

/* START LUMEN */
$app = new Application(
        realpath(__DIR__ . '/../')
);

$app->configure('broadcasting');

/* WEBSOCKET */
$app->register(\Illuminate\Redis\RedisServiceProvider::class);
$app->register(App\Providers\BroadcastServiceProvider::class); //(Broadcast routes)

//use Auth;
$app->router->group(['middleware' => 'jwt-auth'], function($router) {
    $router->post('/broadcasting/auth', function(Illuminate\Http\Request $request) {
        Illuminate\Support\Facades\Broadcast::auth($request);
    });
});
