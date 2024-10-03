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
    $_SESSION['adminPage'] = "validate";

    $alumnis = AlumniModel::getUnverifiedAlumni();
    $employers = EmployerModel::getUnverifiedEmployer();
    $faculty = FacultyModel::getUnverifiedFaculty();
    $db = Flight::db();
    $stmt = $db->prepare("SELECT
      users.id as user_id_alias,
      users.*,
      userdetails.*,
      rejected_users.*
    FROM users 
    LEFT JOIN userdetails 
    ON users.id = userdetails.user_id 
    LEFT JOIN rejected_users
    ON users.id = rejected_users.user_id
    WHERE users.is_verified = '2' 
    ORDER BY userdetails.first_name ASC;
    ");
    $stmt->execute();
    $rejected = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $rejectedAlumni = AlumniModel::getRejectedAlumni();
    $rejectedEmployer = EmployerModel::getRejectedEmployer();
    $rejectedFaculty = FacultyModel::getRejectedFaculty();

    Flight::view()->set('alumniUnverified', $alumnis);
    Flight::view()->set('employerUnverified', $employers);
    Flight::view()->set('facultyUnverified', $faculty);
    Flight::view()->set('rejectedAll', $rejected);
    Flight::view()->set('rejectedAlumni', $rejectedAlumni);
    Flight::view()->set('rejectedEmployer', $rejectedEmployer);
    Flight::view()->set('rejectedFaculty', $rejectedFaculty);

    $this->app->render('admin/validateAlumni', [], 'validateAlumni');
    $this->app->render('admin/validateEmployer', [], 'validateEmployer');
    $this->app->render('admin/validateFaculty', [], 'validateFaculty');
    $this->app->render('admin/rejected', [], 'rejected');
    $this->app->render('admin/validate', ['username' => $_SESSION['username']], 'home');

    Flight::render('header', [], 'header');
    Flight::render('admin/sidebar', [], 'sidebar');
  }

  public function list()
  {
    $_SESSION['adminPage'] = "list";

    $alumniVerified = AlumniModel::getVerifiedAlumni();
    $employerVerified = EmployerModel::getVerifiedEmployer();
    $facultyVerified = FacultyModel::getVerifiedFaculty();

    Flight::view()->set('alumniVerified', $alumniVerified);
    Flight::view()->set('employerVerified', $employerVerified);
    Flight::view()->set('facultyVerified', $facultyVerified);

    $this->app->render('admin/listAlumni', [], 'listAlumni');
    $this->app->render('admin/listEmployer', [], 'listEmployer');
    $this->app->render('admin/listFaculty', [], 'listFaculty');
    $this->app->render('admin/list', ['username' => $_SESSION['username']], 'home');

    Flight::render('header', [], 'header');
    Flight::render('admin/sidebar', [], 'sidebar');
  }

  public function create()
  {
    $_SESSION['adminPage'] = "create";

    $db = Flight::db();

    $stmt = $db->prepare("SELECT * FROM course");
    $stmt->execute();
    $courses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM campuses");
    $stmt->execute();
    $campuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM coursesmajor");
    $stmt->execute();
    $majors = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM faculty_rankings");
    $stmt->execute();
    $acadRanks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM companies");
    $stmt->execute();
    $companies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    bdump($majors);
    bdump(array_column($majors, 'majorName'));
    bdump(array_column($majors, 'major_id'));

    $mapMajors = array_combine(array_column($majors, 'majorName'), array_column($majors, 'major_id'));

    Flight::view()->set('courses', $courses);
    Flight::view()->set('campuses', $campuses);
    Flight::view()->set('majors', $majors);
    Flight::view()->set('acadRanks', $acadRanks);
    Flight::view()->set('companies', $companies);
    Flight::view()->set('mapMajors', $mapMajors);

    $this->app->render('admin/createAlumni', [], 'createAlumni');
    $this->app->render('admin/createEmployer', [], 'createEmployer');
    $this->app->render('admin/createFaculty', [], 'createFaculty');
    $this->app->render('admin/create', ['username' => $_SESSION['username']], 'home');

    Flight::render('header', [], 'header');
    Flight::render('admin/sidebar', [], 'sidebar');
  }

  public function recon()
  {
    $user_id = $_POST['recon_id'];
    $reason = $_POST['reason'];
    $db = Flight::db();
    $stmt = $db->prepare("UPDATE users SET is_verified = 1 WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    if ($stmt) {
      $stmt = $db->prepare("INSERT INTO recon_list (user_id, reason) VALUES (:user_id, :reason)");
      $stmt->execute(['user_id' => $user_id, 'reason' => $reason]);

      bdump($stmt);

      Flight::redirect(Flight::request()->base . '/dashboard/admin/missing');
      $_SESSION['validated'] = true;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    } else {
      $_SESSION['validated'] = false;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    }
  }

  public function approve()
  {
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
    bdump($user_id);
    bdump($reason);
    bdump($dateTime);
    $db = Flight::db();
    $stmt = $db->prepare("UPDATE users SET is_verified = 2 WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    $stmt = $db->prepare("INSERT INTO rejected_users VALUES (:user_id, :reason, :date)");
    $stmt->execute(['user_id' => $user_id, 'reason' => $reason, 'date' => $dateTime]);

    if ($stmt) {
      $_SESSION['rejected'] = true;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    } else {
      $_SESSION['rejected'] = false;
      Flight::redirect(Flight::request()->base . '/dashboard/admin/validate');
    }
  }
}
