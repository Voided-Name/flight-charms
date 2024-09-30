<?php

namespace app\controllers;

use flight\Engine;
use Flight;

Flight::path(__DIR__ . '/../../');

use app\middlewares\guard;
use app\models\AlumniModel;
use app\models\EmployerModel;
use app\models\FacultyModel;

class adminController
{
  protected Engine $app;

  public function __construct($app)
  {
    $this->app = $app;
  }

  public function index()
  {
    guard::requireRole('Admin');
    $_SESSION['adminPage'] = "dashboard";

    $db = Flight::db();
    $stmt = $db->prepare('SELECT COUNT(*) as total FROM employer_job_posts WHERE is_draft = 0');
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

    $numVacancies = $res['total'];
    Flight::view()->set('numVacancies', $numVacancies);

    $stmt = $db->prepare('SELECT COUNT(*) as total FROM users WHERE role = 1 AND is_verified = 1');
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

    $numAlumnis = $res['total'];
    Flight::view()->set('numAlumnis', $numAlumnis);


    $this->app->render('admin/home', ['username' => $_SESSION['username']], 'home');
    Flight::render('header', [], 'header');
    Flight::render('admin/sidebar', [], 'sidebar');
  }

  public function validate()
  {
    session_start();
    $_SESSION['adminPage'] = "validate";

    $alumnis = AlumniModel::getUnverifiedAlumni();
    $employers = EmployerModel::getUnverifiedEmployer();
    $faculty = FacultyModel::getUnverifiedFaculty();

    Flight::view()->set('alumniUnverified', $alumnis);
    Flight::view()->set('employerUnverified', $employers);
    Flight::view()->set('facultyUnverified', $faculty);

    $this->app->render('admin/validateAlumni', [], 'validateAlumni');
    $this->app->render('admin/validateEmployer', [], 'validateEmployer');
    $this->app->render('admin/validateFaculty', [], 'validateFaculty');
    $this->app->render('admin/rejected', [], 'rejected');
    $this->app->render('admin/validate', ['username' => $_SESSION['username']], 'home');

    Flight::render('header', [], 'header');
    Flight::render('admin/sidebar', [], 'sidebar');
  }

  public function approve()
  {
    session_start();
    $user_id = $_POST['approve_id'];
    $db = Flight::db();
    $stmt = $db->prepare("UPDATE users SET is_verified = 1 WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    if ($stmt) {
      $_SESSION['validated'] = true;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    } else {
      $_SESSION['validated'] = false;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    }
  }

  public function reject()
  {
    $user_id = $_POST['delete_id'];
    $reason = $_POST['reason'];
    $dateTime = $_POST['rejected_date'];
    $db = Flight::db();
    $stmt = $db->prepare("UPDATE users SET is_verified = 2 WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    $stmt = $db->prepare("INSERT INTO rejected_users VALUES (:user_id, :reason, :date)");
    $stmt->execute(['user_id' => $user_id, 'reason' => $reason, 'date' => $dateTime]);
    //Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
  }
}
