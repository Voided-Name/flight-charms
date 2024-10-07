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

  public function createAlumni()
  {

    $alumniEmail = strip_tags(Flight::request()->data->alumniEmail);
    $alumniUsername = strip_tags(Flight::request()->data->alumniUsername);
    $alumniFName = strip_tags(Flight::request()->data->alumniFName);
    $alumniLName = strip_tags(Flight::request()->data->alumniLName);
    $alumniMName = strip_tags(Flight::request()->data->alumniMName);
    $alumniSuffix = strip_tags(Flight::request()->data->alumniSuffix);
    $alumniRegion = strip_tags(Flight::request()->data->alumniRegion);
    $alumniProvince = strip_tags(Flight::request()->data->alumniProvince);
    $alumniMunicipality = strip_tags(Flight::request()->data->alumniMunicipality);
    $alumniBarangay = strip_tags(Flight::request()->data->alumniBarangay);
    $alumniStAdd = strip_tags(Flight::request()->data->alumniStAdd);
    $alumniCPNumber = strip_tags(Flight::request()->data->alumniCPNumber);
    $alumniSex = strip_tags(Flight::request()->data->alumniSex);
    $alumniBDate = strip_tags(Flight::request()->data->alumniBDate);
    $alumniStudId = strip_tags(Flight::request()->data->alumniStudId);
    $alumniCourse = strip_tags(Flight::request()->data->alumniCourse);
    $alumniMajor = strip_tags(Flight::request()->data->alumniMajor);
    $alumniCampus = strip_tags(Flight::request()->data->alumniCampus);
    $alumniGraduated = strip_tags(Flight::request()->data->alumniGraduated);
    $alumniEnrolled = strip_tags(Flight::request()->data->alumniEnrolled);
    $alumniPass = md5(strip_tags(Flight::request()->data->alumniPass));
    $alumniConfPass = md5(strip_tags(Flight::request()->data->alumniConfPass));

    if ($alumniMajor == "N/A") {
      $alumniMajor = 17;
    }

    // errs
    $err = false;
    $alumniEmailExists = false;
    $alumniUsernameExists = false;
    $alumniPassDifferent = false;

    if (baseController::checkEmailExists($alumniEmail)) {
      $alumniEmailExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if (baseController::checkUsernameExists($alumniUsername)) {
      $alumniUsernameExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if ($alumniPass != $alumniConfPass) {
      $alumniPassDifferent = true;
    }

    if ($err) {
      $_SESSION['alumniEmailExists'] = $alumniEmailExists;
      $_SESSION['alumniUsernameExists'] = $alumniUsernameExists;
      $_SESSION['alumniPassDifferent'] = $alumniPassDifferent;
      $_SESSION['createInvalid'] = true;

      Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
      exit();
    }

    $created_at = date('Y-m-d H:i:s');
    $db = Flight::db();
    $stmt = $db->prepare('INSERT INTO users (username, password, role, is_verified, created_at) VALUES (:alumniUsername, :alumniPass, 1, 1, :created_at)');
    $status = $stmt->execute(['alumniUsername' => $alumniUsername, 'alumniPass' => $alumniPass, 'created_at' => $created_at]);

    if ($status) {
      $userId = $db->lastInsertId();
      $stmt = $db->prepare('INSERT INTO userdetails (user_id, email_address, contact_number, first_name, middle_name, last_name, suffix, birth_date, sex, region, province, city, barangay, street_add) VALUES (:user_id, :alumniEmail, :alumniCPNumber, :alumniFName, :alumniMName, :alumniLName, :alumniSuffix, :alumniBDate, :alumniSex, :alumniRegion, :alumniProvince, :alumniMunicipality, :alumniBarangay, :alumniStAdd)');
      $status = $stmt->execute(['user_id' => $userId, 'alumniEmail' => $alumniEmail, 'alumniCPNumber' => $alumniCPNumber, 'alumniFName' => $alumniFName, 'alumniMName' => $alumniMName, 'alumniLName' => $alumniLName, "alumniSuffix" => $alumniSuffix, "alumniBDate" => $alumniBDate, "alumniSex" => $alumniSex, "alumniRegion" => $alumniRegion, "alumniProvince" => $alumniProvince, "alumniMunicipality" => $alumniMunicipality, "alumniBarangay" => $alumniBarangay, "alumniStAdd" => $alumniStAdd]);
      $stmt = $db->prepare('INSERT INTO alumni_graduated_course (user_id, studnum, course_id, major_id, campus, year_started, year_graduated) VALUES (:user_id, :alumniStudId, :alumniCourse, :alumniMajor, :alumniCampus, :alumniEnrolled, :alumniGraduated)');
      $status = $stmt->execute(['user_id' => $userId, 'alumniStudId' => $alumniStudId, 'alumniCourse' => $alumniCourse, 'alumniMajor' => $alumniMajor, 'alumniCampus' => $alumniCampus, 'alumniEnrolled' => $alumniEnrolled, "alumniGraduated" => $alumniGraduated]);
    }

    $_SESSION["createValid"] = true;

    Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
  }

  public function createEmployer()
  {
    $employerEmail = strip_tags(Flight::request()->data->employerEmail);
    $employerUsername = strip_tags(Flight::request()->data->employerUsername);
    $employerFName = strip_tags(Flight::request()->data->employerFName);
    $employerLName = strip_tags(Flight::request()->data->employerLName);
    $employerMName = strip_tags(Flight::request()->data->employerMName);
    $employerSuffix = strip_tags(Flight::request()->data->employerSuffix);
    $employerRegion = strip_tags(Flight::request()->data->employerRegion);
    $employerProvince = strip_tags(Flight::request()->data->employerProvince);
    $employerMunicipality = strip_tags(Flight::request()->data->employerMunicipality);
    $employerBarangay = strip_tags(Flight::request()->data->employerBarangay);
    $employerStAdd = strip_tags(Flight::request()->data->employerStAdd);
    $employerCPNumber = strip_tags(Flight::request()->data->employerCPNumber);
    $employerSex = strip_tags(Flight::request()->data->employerSex);
    $employerBDate = strip_tags(Flight::request()->data->employerBDate);
    $employerPass = md5(strip_tags(Flight::request()->data->employerPass));
    $employerConfPass = md5(strip_tags(Flight::request()->data->employerConfPass));

    $employerCompany = strip_tags(Flight::request()->data->employerCompany);
    $employerID = strip_tags(Flight::request()->data->employerID);
    $employerPosition = strip_tags(Flight::request()->data->employerPosition);

    $err = false;
    $employerEmailExists = false;
    $employerUsernameExists = false;
    $employerPassDifferent = false;

    if (baseController::checkEmailExists($employerEmail)) {
      $employerEmailExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if (baseController::checkUsernameExists($employerUsername)) {
      $employerUsernameExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if ($employerPass != $employerConfPass) {
      $employerPassDifferent = true;
    }

    if ($err) {
      $_SESSION['employerEmailExists'] = $employerEmailExists;
      $_SESSION['employerUsernameExists'] = $employerUsernameExists;
      $_SESSION['employerPassDifferent'] = $employerPassDifferent;
      $_SESSION['createInvalid'] = true;

      Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
      exit();
    }

    $db = Flight::db();

    if ($employerCompany == 0) {
      $employerCompany = Flight::request()->data->employerCompanySTR;
      $stmt = $db->prepare('INSERT INTO companies (company_name) VALUES (:company_name)');
      $status = $stmt->execute(['company_name' => $employerCompany]);
      $employerCompany = $db->lastInsertId;
    }

    $created_at = date('Y-m-d H:i:s');
    $stmt = $db->prepare('INSERT INTO users (username, password, role, is_verified, created_at) VALUES (:employerUsername, :employerPass, 2, 1, :created_at)');
    $status = $stmt->execute(['employerUsername' => $employerUsername, 'employerPass' => $employerPass, 'created_at' => $created_at]);

    if ($status) {
      $userId = $db->lastInsertId();
      $stmt = $db->prepare('INSERT INTO userdetails (user_id, email_address, contact_number, first_name, middle_name, last_name, suffix, birth_date, sex, region, province, city, barangay, street_add) VALUES (:user_id, :employerEmail, :employerCPNumber, :employerFName, :employerMName, :employerLName, :employerSuffix, :employerBDate, :employerSex, :employerRegion, :employerProvince, :employerMunicipality, :employerBarangay, :employerStAdd)');
      $status = $stmt->execute(['user_id' => $userId, 'employerEmail' => $employerEmail, 'employerCPNumber' => $employerCPNumber, 'employerFName' => $employerFName, 'employerMName' => $employerMName, 'employerLName' => $employerLName, "employerSuffix" => $employerSuffix, "employerBDate" => $employerBDate, "employerSex" => $employerSex, "employerRegion" => $employerRegion, "employerProvince" => $employerProvince, "employerMunicipality" => $employerMunicipality, "employerBarangay" => $employerBarangay, "employerStAdd" => $employerStAdd]);
      $stmt = $db->prepare('INSERT INTO employer_users (user_id, employer_num, company_id, company_position) VALUES (:user_id, :employerID, :employerCompany, :employerPosition)');
      $status = $stmt->execute(['user_id' => $userId, 'employerID' => $employerID, 'employerCompany' => $employerCompany, 'employerPosition' => $employerPosition]);
    }

    $_SESSION['createValid'] = true;

    Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
  }

  public function createFaculty()
  {
    $facultyEmail = strip_tags(Flight::request()->data->facultyEmail);
    $facultyUsername = strip_tags(Flight::request()->data->facultyUsername);
    $facultyFName = strip_tags(Flight::request()->data->facultyFName);
    $facultyLName = strip_tags(Flight::request()->data->facultyLName);
    $facultyMName = strip_tags(Flight::request()->data->facultyMName);
    $facultySuffix = strip_tags(Flight::request()->data->facultySuffix);
    $facultyRegion = strip_tags(Flight::request()->data->facultyRegion);
    $facultyProvince = strip_tags(Flight::request()->data->facultyProvince);
    $facultyMunicipality = strip_tags(Flight::request()->data->facultyMunicipality);
    $facultyBarangay = strip_tags(Flight::request()->data->facultyBarangay);
    $facultyStAdd = strip_tags(Flight::request()->data->facultyStAdd);
    $facultyCPNumber = strip_tags(Flight::request()->data->facultyCPNumber);
    $facultySex = strip_tags(Flight::request()->data->facultySex);
    $facultyBDate = strip_tags(Flight::request()->data->facultyBDate);
    $facultyPass = md5(strip_tags(Flight::request()->data->facultyPass));
    $facultyConfPass = md5(strip_tags(Flight::request()->data->facultyConfPass));

    $facultyRank = strip_tags(Flight::request()->data->facultyRank);
    $facultyCampus = strip_tags(Flight::request()->data->facultyCampus);
    $facultyID = strip_tags(Flight::request()->data->facultyID);

    $err = false;
    $facultyEmailExists = false;
    $facultyUsernameExists = false;
    $facultyPassDifferent = false;

    if (baseController::checkEmailExists($facultyEmail)) {
      $facultyEmailExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if (baseController::checkUsernameExists($facultyUsername)) {
      $facultyUsernameExists = true;
      if (!$err) {
        $err = true;
      }
    }

    if ($facultyPass != $facultyConfPass) {
      $facultyPassDifferent = true;
    }

    if ($err) {
      $_SESSION['facultyEmailExists'] = $facultyEmailExists;
      $_SESSION['facultyUsernameExists'] = $facultyUsernameExists;
      $_SESSION['facultyPassDifferent'] = $facultyPassDifferent;
      $_SESSION['createInvalid'] = true;

      Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
      exit();
    }

    $db = Flight::db();

    $created_at = date('Y-m-d H:i:s');
    $stmt = $db->prepare('INSERT INTO users (username, password, role, is_verified, created_at) VALUES (:facultyUsername, :facultyPass, 3, 1, :created_at)');
    $status = $stmt->execute(['facultyUsername' => $facultyUsername, 'facultyPass' => $facultyPass, 'created_at' => $created_at]);

    if ($status) {
      $userId = $db->lastInsertId();
      $stmt = $db->prepare('INSERT INTO userdetails (user_id, email_address, contact_number, first_name, middle_name, last_name, suffix, birth_date, sex, region, province, city, barangay, street_add) VALUES (:user_id, :facultyEmail, :facultyCPNumber, :facultyFName, :facultyMName, :facultyLName, :facultySuffix, :facultyBDate, :facultySex, :facultyRegion, :facultyProvince, :facultyMunicipality, :facultyBarangay, :facultyStAdd)');
      $status = $stmt->execute(['user_id' => $userId, 'facultyEmail' => $facultyEmail, 'facultyCPNumber' => $facultyCPNumber, 'facultyFName' => $facultyFName, 'facultyMName' => $facultyMName, 'facultyLName' => $facultyLName, "facultySuffix" => $facultySuffix, "facultyBDate" => $facultyBDate, "facultySex" => $facultySex, "facultyRegion" => $facultyRegion, "facultyProvince" => $facultyProvince, "facultyMunicipality" => $facultyMunicipality, "facultyBarangay" => $facultyBarangay, "facultyStAdd" => $facultyStAdd]);
      $stmt = $db->prepare('INSERT INTO faculty (user_id, employee_num, campus_id, acadrank_id) VALUES (:user_id, :facultyID, :facultyCampus, :facultyRank)');
      $status = $stmt->execute(['user_id' => $userId, 'facultyID' => $facultyID, 'facultyCampus' => $facultyCampus, 'facultyRank' => $facultyRank]);
    }

    $_SESSION['createValid'] = true;

    Flight::redirect(Flight::request()->base . '/dashboard/admin/create');
  }

  public function create()
  {
    $_SESSION['adminPage'] = "create";

    $db = Flight::db();

    $stmt = $db->prepare("SELECT * FROM courses");
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
    bdump($courses);
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

  public function checkEmail()
  {
    $fieldName = $_POST['fieldName'];

    $email = $_POST[$fieldName];
    $exists = baseController::checkEmailExists($email);

    if ($exists) {
      echo "exists";
    }
  }

  public function checkUsername()
  {
    $fieldName = $_POST['fieldName'];

    $email = $_POST[$fieldName];
    $exists = baseController::checkUsernameExists($email);

    if ($exists) {
      echo "exists";
    }
  }
}
