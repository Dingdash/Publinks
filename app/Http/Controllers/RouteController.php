<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use \Route;

class RouteController extends Controller
{
    public function index()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'host'   => $route->domain(),
                'method' => implode('|', $route->methods()),
                'uri'    => $route->uri(),
                'name'   => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });
        return view('listroute', array('list' => $routes));
    }
}
