<?php

namespace app\controllers;

use flight\Engine;
use Flight;

Flight::path(__DIR__ . '/../../');

use app\middlewares\guard;
use app\models\AlumniModel;
use app\models\EmployerModel;
use app\models\FacultyModel;
use app\controllers\baseController;

class alumniController
{
  protected Engine $app;

  public function __construct($app)
  {
    $this->app = $app;
  }

  public function index()
  {
    $_SESSION['alumniPage'] = "dashboard";

    $this->app->render('alumni/home', ['username' => $_SESSION['username']], 'home');
    Flight::render('header', [], 'header');
    Flight::render('alumni/sidebar', [], 'sidebar');
  }

  public function awards()
  {
    $_SESSION['alumniPage'] = "awards";

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM alumni_awards WHERE alumni_userID = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniAwardsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set('alumniAwardsData', $alumniAwardsData);

    Flight::render('header', [], 'header');
    Flight::render('alumni/awardRows', [], 'rows');
    Flight::render('alumni/sidebar', [], 'sidebar');


    $this->app->render('alumni/awards', [
      'username' => $_SESSION['username'],
      'alumniAwardsData' => $alumniAwardsData
    ], 'home');
  }
}
