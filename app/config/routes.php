<?php

use app\controllers\ApiExampleController;
use app\controllers\baseController;
use app\controllers\adminController;
use app\controllers\alumniController;
use app\controllers\employerController;
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

Flight::route('/locations/regions', function () {
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  Flight::render('regions.php', ['regions' => $locations]);
});

Flight::route('/locations/provinces', function () {
  $region = Flight::request()->query->regions;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $provinces = $locations[$region]['province_list'] ?? [];
  Flight::render('provinces.php', ['provinces' => $provinces]);
});

Flight::route('/locations/municipalities', function () {
  $region = Flight::request()->query->regions;
  $province = Flight::request()->query->provinces;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $municipalities = $locations[$region]['province_list'][$province]['municipality_list'] ?? [];
  bdump($region);
  bdump($province);
  bdump($municipalities);
  Flight::render('municipalities.php', ['municipalities' => $municipalities]);
});

Flight::route('/locations/barangays', function () {
  $region = Flight::request()->query->regions;
  $province = Flight::request()->query->provinces;
  $municipality = Flight::request()->query->municipalities;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $barangays = $locations[$region]['province_list'][$province]['municipality_list'][$municipality]['barangay_list'] ?? [];
  bdump($region);
  bdump($province);
  bdump($municipality);
  bdump($barangays);
  Flight::render('barangays.php', ['barangays' => $barangays]);
});



$router->group('/dashboard', function () use ($router, $app) {
  // Admin Dashboard
  $router->group('/admin', function () use ($router, $app) {
    $router->get('/', [adminController::class, 'index'], false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->post('/checkEmail', [adminController::class, 'checkEmail'], false, 'adminCheckEmail');
    $router->post('/checkUsername', [adminController::class, 'checkUsername'], false, 'adminCheckUsername');
    $router->get('/validate', [adminController::class, 'validate'], false, 'adminValidate')->addMiddleware([new layoutDefault()]);
    $router->post('/approve', [adminController::class, 'approve']);
    $router->post('/reject', [adminController::class, 'reject']);
    $router->post('/recon', [adminController::class, 'recon']);
    $router->get('/list', [adminController::class, 'list'], false, 'adminList')->addMiddleware([new layoutDefault()]);
    $router->get('/create', [adminController::class, 'create'], false, 'adminCreate')->addMiddleware([new layoutDefault()]);
    $router->post('/createAlumni', [adminController::class, 'createAlumni'], false, 'adminCreateAlumni');
    $router->post('/createEmployer', [adminController::class, 'createEmployer'], false, 'adminCreateEmployer');
    $router->post('/createFaculty', [adminController::class, 'createFaculty'], false, 'adminCreateFaculty');
    $router->get('/generate', function () use ($app) {
      session_start();
      $_SESSION['adminPage'] = "generate";
      $app->render('admin/generate', ['username' => $_SESSION['username']], 'home');
      Flight::render('header', [], 'header');
      Flight::render('admin/sidebar', [], 'sidebar');
      $app->render('admin/generate');
    }, false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->get('/create', function () use ($app) {}, false, 'adminhome')->addMiddleware([new layoutDefault()]);
  }, [new guard('Admin')]);

  // Faculty Dashboard
  $router->get('/faculty', function () use ($app) {
    $app->render('faculty/home', ['username' => $_SESSION['username']]);
  })->addMiddleware([new guard('Faculty')]);

  // Employer Dashboard

  $router->group('/employer', function () use ($router, $app) {
    $router->get('/', [employerController::class, 'index'], false, 'employerHome')->addMiddleware([new layoutDefault()]);
    $router->get('/createVacancy', [employerController::class, 'createVacancy', false, 'employerCreateVacancy'])->addMiddleware([new layoutDefault()]);
    $router->post('/createVacancySubmit', [employerController::class, 'createVacancySubmit', false, 'employerCreateVacancySubmit']);
    $router->get('/jobVacancies', [employerController::class, 'jobVacancies', false, 'employerJobVacancies'])->addMiddleware([new layoutDefault()]);
    $router->get('/jobVacanciesEdit', [employerController::class, 'jobVacanciesEdit', false, 'employerJobVacanciesEdit'])->addMiddleware([new layoutDefault()]);
    $router->post('/editJobVacancy', [employerController::class, 'editJobVacancy', false, 'employerEditJobVacancy']);
    $router->get('/viewApps', [employerController::class, 'viewApps'], false, 'employerViewApps')->addMiddleware([new layoutDefault()]);
    $router->get('/deleteVacancy', [employerController::class, 'deleteVacancy', false, 'employerDeleteVacancy']);
    $router->get('/testLocation', function () {
      Flight::render('employer/locationTest');
    });

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'employerViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'employerVacancyPagination');
  }, [new guard('Employer')]);


  $router->group('/alumni', function () use ($router, $app) {
    $router->get('/', [alumniController::class, 'index'], false, 'alumnihome')->addMiddleware([new layoutDefault()]);
    $router->get('/awards', [alumniController::class, 'awards'], false, 'alumniAwards')->addMiddleware([new layoutDefault()]);
    $router->post('/addAward', [alumniController::class, 'addAward', false, 'alumniAddAward']);
    $router->post('/editAward', [alumniController::class, 'editAward', false, 'alumniEditAward']);
    $router->post('/deleteAward', [alumniController::class, 'deleteAward', false, 'alumniDeleteAward']);
    $router->get('/workExp', [alumniController::class, 'workExp'], false, 'alumniWorkExp')->addMiddleware([new layoutDefault()]);
    $router->post('/addWorkExp', [alumniController::class, 'addWorkExp', false, 'alumniAddWorkExp']);
    $router->post('/editWorkExp', [alumniController::class, 'editWorkExp', false, 'alumniEditWorkExp']);
    $router->post('/deleteWorkExp', [alumniController::class, 'deleteWorkExp', false, 'alumniDeleteWorkExp']);

    $router->get('/hello', function () {
      echo "hello";
    });

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'alumniViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'alumniVacancyPagination');
    $router->get('/apply', [baseController::class, 'apply'], false, 'alumniApply')->addMiddleware([new layoutDefault()]);
    $router->get('/apply', [baseController::class, 'apply'], false, 'alumniApply')->addMiddleware([new layoutDefault()]);
  }, [new guard('Alumni')]);
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
