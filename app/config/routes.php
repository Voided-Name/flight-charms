<?php

use app\controllers\ApiExampleController;
use app\controllers\baseController;
use app\controllers\adminController;
use app\controllers\alumniController;
use app\controllers\employerController;
use app\controllers\facultyController;
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
$router->get('/announcements', [baseController::class, 'announcements']);
$router->get('/verifying/alumni', [baseController::class, 'verifyingAlumni']);
$router->get('/verifying/faculty', [baseController::class, 'verifyingFaculty']);
$router->get('/verifying/employer', [baseController::class, 'verifyingEmployer']);
$router->post('/verifying/verifyingAlumniSave', [baseController::class, 'verifyingAlumniSave']);
$router->post('/verifying/verifyingFacultySave', [baseController::class, 'verifyingFacultySave']);
$router->post('/verifying/verifyingEmployerSave', [baseController::class, 'verifyingEmployerSave']);

Flight::route('/locations/regions', function () {
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $region = Flight::request()->query->currentRegion;
  Flight::render('regions.php', ['regions' => $locations, 'region' => $region]);
});

Flight::route('/locations/provinces', function () {
  $region = Flight::request()->query->regions;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $currentProvince = Flight::request()->query->currentProvince;
  $provinces = $locations[$region]['province_list'] ?? [];
  Flight::render('provinces.php', ['provinces' => $provinces, 'currentProvince' => $currentProvince]);
});

Flight::route('/locations/municipalities', function () {
  $region = Flight::request()->query->regions;
  $province = Flight::request()->query->provinces;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $municipalities = $locations[$region]['province_list'][$province]['municipality_list'] ?? [];
  $currentMunicipality = Flight::request()->query->currentMunicipality;
  Flight::render('municipalities.php', ['municipalities' => $municipalities, 'currentMunicipality' => $currentMunicipality]);
});

Flight::route('/locations/barangays', function () {
  $region = Flight::request()->query->regions;
  $province = Flight::request()->query->provinces;
  $municipality = Flight::request()->query->municipalities;
  $locations = json_decode(file_get_contents('assets/locations.json'), true);
  $barangays = $locations[$region]['province_list'][$province]['municipality_list'][$municipality]['barangay_list'] ?? [];
  $currentBarangay = Flight::request()->query->currentBarangay;
  Flight::render('barangays.php', ['barangays' => $barangays, 'currentBarangay' => $currentBarangay]);
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
    $router->post('/generateReport', [adminController::class, 'generateReport'], false, 'adminGenerateReport');
    $router->get('/generate', function () use ($app) {
      session_start();
      $_SESSION['adminPage'] = "generate";
      $app->render('admin/generate', ['username' => $_SESSION['username']], 'home');
      Flight::render('header', [], 'header');
      Flight::render('admin/sidebar', [], 'sidebar');
      $app->render('admin/generate');
    }, false, 'adminhome')->addMiddleware([new layoutDefault()]);
    $router->get('/create', function () use ($app) {}, false, 'adminhome')->addMiddleware([new layoutDefault()]);

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'adminViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'adminVacancyPagination');
    $router->get('/apply', [baseController::class, 'apply'], false, 'adminApply')->addMiddleware([new layoutDefault()]);
  }, [new guard('Admin')]);

  // Faculty Dashboard
  $router->group('/faculty', function () use ($router, $app) {
    $router->get('/', [facultyController::class, 'index'], false, 'facultyHome')->addMiddleware([new layoutDefault()]);
    $router->get('/postAnnouncement', [facultyController::class, 'postAnnouncement'], false, 'facultyPostAnnouncement')->addMiddleware([new layoutDefault()]);
    $router->post('/announcementEdit', [facultyController::class, 'editAnnouncement'], false, 'facultyEditAnnouncement');
    $router->post('/deleteAnnouncement', [facultyController::class, 'deleteAnnouncement'], false, 'facultyDeleteAnnouncement');
    $router->post('/postAnnouncementMethod', [facultyController::class, 'postAnnouncementMethod'], false, 'facultyPostAnnouncementMethod');
    $router->get('/postAnnouncementManage', [facultyController::class, 'postAnnouncementManage'], false, 'facultyPostAnnouncementManage')->addMiddleware([new layoutDefault()]);

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'facultyViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'facultyVacancyPagination');
    $router->get('/apply', [baseController::class, 'apply'], false, 'facultyApply')->addMiddleware([new layoutDefault()]);
  }, [new guard('Faculty')]);

  // Employer Dashboard

  $router->group('/employer', function () use ($router, $app) {
    $router->get('/', [employerController::class, 'index'], false, 'employerHome')->addMiddleware([new layoutDefault()]);
    $router->get('/createVacancy', [employerController::class, 'createVacancy'], false, 'employerCreateVacancy')->addMiddleware([new layoutDefault()]);
    $router->post('/createVacancySubmit', [employerController::class, 'createVacancySubmit'], false, 'employerCreateVacancySubmit');
    $router->get('/jobVacancies', [employerController::class, 'jobVacancies'], false, 'employerJobVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/jobVacanciesEdit', [employerController::class, 'jobVacanciesEdit'], false, 'employerJobVacanciesEdit')->addMiddleware([new layoutDefault()]);
    $router->post('/editJobVacancy', [employerController::class, 'editJobVacancy'], false, 'employerEditJobVacancy');
    $router->get('/viewApps', [employerController::class, 'viewApps'], false, 'employerViewApps')->addMiddleware([new layoutDefault()]);
    $router->post('/viewProfile', [baseController::class, 'viewProfile'], false, 'employerViewProfile')->addMiddleware([new layoutDefault()]);
    $router->get('/viewApps/viewFile', [employerController::class, 'viewAppsInstance'], false, 'employerViewAppsInstance');
    $router->post('/viewApps/employ', [employerController::class, 'viewAppsEmploy'], false, 'employerViewAppsEmploy');
    $router->post('/viewApps/reject', [employerController::class, 'viewAppsReject'], false, 'employerViewAppsReject');
    $router->get('/deleteVacancy', [employerController::class, 'deleteVacancy'], false, 'employerDeleteVacancy');
    $router->get('/testLocation', function () {
      Flight::render('employer/locationTest');
    });

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'employerViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'employerVacancyPagination');
    $router->get('/apply', [baseController::class, 'apply'], false, 'adminApply')->addMiddleware([new layoutDefault()]);
  }, [new guard('Employer')]);


  $router->group('/alumni', function () use ($router, $app) {
    $router->get('/', [alumniController::class, 'index'], false, 'alumnihome')->addMiddleware([new layoutDefault()]);
    $router->get('/awards', [alumniController::class, 'awards'], false, 'alumniAwards')->addMiddleware([new layoutDefault()]);
    $router->post('/addAward', [alumniController::class, 'addAward'], false, 'alumniAddAward');
    $router->post('/editAward', [alumniController::class, 'editAward'], false, 'alumniEditAward');
    $router->post('/deleteAward', [alumniController::class, 'deleteAward'], false, 'alumniDeleteAward');
    $router->get('/workExp', [alumniController::class, 'workExp'], false, 'alumniWorkExp')->addMiddleware([new layoutDefault()]);
    $router->post('/addWorkExp', [alumniController::class, 'addWorkExp'], false, 'alumniAddWorkExp');
    $router->post('/editWorkExp', [alumniController::class, 'editWorkExp'], false, 'alumniEditWorkExp');
    $router->post('/deleteWorkExp', [alumniController::class, 'deleteWorkExp'], false, 'alumniDeleteWorkExp');
    $router->post('/submitApp', [alumniController::class, 'submitApp'], false, 'alumniSubmitApp');
    $router->get('/generateResume', [alumniController::class, 'generateResume'], false, 'alumniGenerateResume')->addMiddleware([new layoutDefault()]);
    $router->post('/generateResumePDF', [alumniController::class, 'generateResumePDF'], false, 'alumniGenerateResumePDF');

    $router->get('/hello', function () {
      echo "hello";
    });

    $router->get('/allVacancies', [baseController::class, 'allVacancies'], false, 'alumniViewVacancies')->addMiddleware([new layoutDefault()]);
    $router->get('/vacancyPagination', [baseController::class, 'vacancyPagination'], false, 'alumniVacancyPagination');
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
