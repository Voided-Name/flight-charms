<?php

use app\controllers\ApiExampleController;
use app\controllers\baseController;
use app\controllers\adminController;
use app\middlewares\guard;
use app\middlewares\layoutDefault;
use flight\Engine;
use flight\net\Router;


/** 
 * @var Router $router 
 * @var Engine $app
 */
$baseController = new baseController($app);
$adminController = new adminController($app);

$router->get('/', [baseController::class, 'index']);
$router->get('/about', [baseController::class, 'about']);
$router->get('/contact', [baseController::class, 'contact']);
$router->get('/logout', [baseController::class, 'logout']);
$router->get('/register', [baseController::class, 'register']);
$router->post('/register', [baseController::class, 'registerBtn']);
$router->get('/login', [baseController::class, 'login']);
$router->post('/login', [baseController::class, 'loginBtn']);


$router->group('/dashboard', function () use ($router, $app) {
  // Admin Dashboard
  $router->group('/admin', function () use ($router, $app) {
    $router->get('/', [adminController::class, 'index'], false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->get('/validate', [adminController::class, 'validate'], false, 'adminValidate')->addMiddleware([new layoutDefault()]);
    $router->post('/approve', [adminController::class, 'approve']);
    $router->post('/reject', [adminController::class, 'reject']);
    $router->post('/recon', [adminController::class, 'recon']);
    $router->get('/list', function () use ($app) {
      session_start();
      $_SESSION['adminPage'] = "list";
      $app->render('admin/list', ['username' => $_SESSION['username']], 'home');
      Flight::render('header', [], 'header');
      Flight::render('admin/sidebar', [], 'sidebar');
      $app->render('admin/list');
    }, false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->get('/generate', function () use ($app) {
      session_start();
      $_SESSION['adminPage'] = "generate";
      $app->render('admin/generate', ['username' => $_SESSION['username']], 'home');
      Flight::render('header', [], 'header');
      Flight::render('admin/sidebar', [], 'sidebar');
      $app->render('admin/generate');
    }, false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->get('/create', function () use ($app) {
      session_start();
      $_SESSION['adminPage'] = "create";
      $app->render('admin/create', ['username' => $_SESSION['username']], 'home');
      Flight::render('header', [], 'header');
      Flight::render('admin/sidebar', [], 'sidebar');
      $app->render('admin/create');
    }, false, 'adminhome')->addMiddleware([new layoutDefault()]);
  });

  // Faculty Dashboard
  $router->get('/faculty', function () use ($app) {
    guard::requireRole('Faculty');
    $app->render('faculty/home', ['username' => $_SESSION['username']]);
  });

  // Employer Dashboard
  $router->get('/employer', function () use ($app) {
    guard::requireRole('Employer');
    $app->render('employer/home', ['username' => $_SESSION['username']]);
  });

  // Alumni Dashboard
  $router->get('/alumni', function () use ($app) {
    guard::requireRole('Alumni');

    Flight::render('alumni/sidebar', [], 'sidebar');
    Flight::render('alumni/home', ['username' => $_SESSION['username']], 'home');
  }, false, 'alumnihome')->addMiddleware([new layoutDefault()]);
});

$router->get('/unauthorized', function () use ($app) {
  $app->render('404');
});

Flight::map('notFound', function () use ($app) {
  // Set the HTTP status to 404
  header('HTTP/1.1 404 Not Found');
  // Render your custom 404 page
  $app->render('404');
});


$router->group('/api', function () use ($router, $app) {
  $Api_Example_Controller = new ApiExampleController($app);
  $router->get('/users', [$Api_Example_Controller, 'getUsers']);
  $router->get('/users/@id:[0-9]', [$Api_Example_Controller, 'getUser']);
  $router->post('/users/@id:[0-9]', [$Api_Example_Controller, 'updateUser']);
});
