<?php

// Inicialicación de errores
// Habilitar la muestra de errores.
// Solo para versión de test
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

//Inicializar sesión

session_start();

//cargar las variables de entorno
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;


//Se carga la configuración para el trabajo de conexión a base de datos como un ORM
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      =>  getenv('DB_HOST'),
    'database'  =>  getenv('DB_NAME'),
    'username'  =>  getenv('DB_USER'),
    'password'  =>  getenv('DB_PASS'),
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

//users

$map->get('addUsers', $baseRoute . '/users/add',  [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getIndexUser'
]);

$map->post('saveUsers', $baseRoute . '/users/add',  [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'postAddUser'
]);

//Login
$map->get('LoginForm', $baseRoute . '/login',  [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin'
]);

$map->post('auth', $baseRoute . '/auth',  [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin'
]);

$map->get('logout', $baseRoute . '/logout',  [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout'
]);


//admin
$map->get('admin', $baseRoute . '/admin',  [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'getIndex',
    'auth' => true
]);





//redireccionamiento de las rutas
$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'No route';
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false;
    $sessionUserId = $_SESSION['userId'] ?? null;
    if ($needsAuth && !$sessionUserId) {
        echo 'Protected route';
        die;
    }

    $controller = new  $controllerName;
    $response = $controller->$actionName($request);

    //enviar las cabeceras

    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s %s', $name, $value), false);
        }
    }
    //enviar código de respuestas
    http_response_code($response->getStatusCode());

    //para enviar la respuesta del cuerpo a la vista
    echo $response->getBody();
}
