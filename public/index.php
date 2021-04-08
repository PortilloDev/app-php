<?php

// Inicialicación de errores
// Habilitar la muestra de errores.
// Solo para versión de test
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

password_hash('superSecurePaswd', PASSWORD_DEFAULT);

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;


//Se carga la configuración para el trabajo de conexión a base de datos como un ORM
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'php',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

function printElement($job)
{

    echo '<li class="work-position">';
    echo ' <h5>' . $job->title . '</h5>';
    echo ' <p>' . $job->description . '</p>';
    echo ' <p>' . $job->getDurationAsString() . '</p>';
    echo ' <strong>Achievements:</strong>';
    echo '  <ul>';
    echo '   <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit . </li>';
    echo '   <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit. </li>';
    echo '   <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit. </li>';
    echo '  </ul>';
    echo '</li>';
}

//En está parte se carga las rutas de la aplicación
use Laminas\Diactoros\ServerRequestFactory;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

//Root
$baseRoute = '/app-php';

//ruta index
$map->get('index', $baseRoute . '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);

//rutas jobs
$map->get('addJobs', $baseRoute . '/jobs/add',  [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getIndexJob'
]);

$map->post('saveJobs', $baseRoute . '/jobs/add',  [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
]);

//rutas projects
$map->get('addProjects', $baseRoute . '/projects/add',  [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getIndexProject'
]);

$map->post('saveProjects', $baseRoute . '/projects/add',  [
    'controller' => 'App\Controllers\ProjectsController',
    'action' => 'getAddProjectsAction'
]);



$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No route';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];


    $controller = new  $controllerName;
    $response = $controller->$actionName($request);

    //para enviar la respuesta a la vista
    echo $response->getBody();
}
