<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

Foundation::group('blupl/match', 'match', ['namespace' => 'Blupl\Match\Http\Controllers'], function (Router $router) {

        $router->get('create', 'MatchController@create');
});

/*
|--------------------------------------------------------------------------
| Backend Routing
|--------------------------------------------------------------------------
*/

Foundation::namespaced('Blupl\Match\Http\Controllers\Admin', function (Router $router) {
    $router->group(['prefix' => 'match'], function (Router $router) {
        $router->get('/', 'HomeController@index');
        $router->match(['GET', 'HEAD', 'DELETE'], 'profile/{roles}/delete', 'HomeController@delete');

    });
});
