<?php

// require_once dirname(__DIR__) . '/app/App.php';
session_start();
require '../vendor/autoload.php';

use App\App;
use Core\Helper\BaseHelpers;
use Core\Routing\URL;
use Core\Routing\Router;
use Core\Routing\RouteNotFoundException;

//Error reporting
define('DEBUG_MODE', true);
define('ROOT', dirname(__DIR__));

if(DEBUG_MODE){
    ini_set('xdebug.max_nesting_level', 200);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// App::load();

$router = new Router();
require_once "../routes/api.php";
require_once "../routes/web.php";

$helper = new BaseHelpers();
$helper->declareDebug();

$action = str_replace( strtolower(App::base_url()) , "", strtolower(App::full_url()) );


URL::registerRouter($router);

try{
    $router->call($action);
}catch(RouteNotFoundException $ex){
    //App::abort(404);
}


if (isset($_SESSION['input'])) unset($_SESSION['input']);