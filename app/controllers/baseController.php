<?php

namespace app\controllers;

use flight\Engine;
use Flight;

class baseController
{

  protected Engine $app;

  public function __construct($app)
  {
    $this->app = $app;
  }

  public function index()
  {
    Flight::view()->set('homestyle', 'style="font-weight: bold" ');
    Flight::view()->set('aboutstyle', '');
    Flight::view()->set('contactstyle', '');
    $this->app->render('landing_page_header', [], 'header');
    $this->app->render('landing_stylesheets', [], 'stylesheets');
    $this->app->render('landing_scripts', [], 'scripts');
    $this->app->render('landing_page');
  }

  public function about()
  {
    Flight::view()->set('aboutstyle', 'style="font-weight: bold" ');
    Flight::view()->set('homestyle', '');
    Flight::view()->set('contactstyle', '');
    $this->app->render('landing_page_header', [], 'header');
    $this->app->render('landing_stylesheets', [], 'stylesheets');
    $this->app->render('landing_scripts', [], 'scripts');
    $this->app->render('about');
  }

  public function contact()
  {
    Flight::view()->set('contactstyle', 'style="font-weight: bold" ');
    Flight::view()->set('homestyle', '');
    Flight::view()->set('aboutstyle', '');
    $this->app->render('landing_page_header', [], 'header');
    $this->app->render('landing_stylesheets', [], 'stylesheets');
    $this->app->render('landing_scripts', [], 'scripts');
    $this->app->render('contact');
  }

  public function logout()
  {
    session_start();
    session_destroy();
    Flight::redirect(Flight::request()->base);
  }

  public function register()
  {
    Flight::view()->set('allcompany', baseController::getCompanies());
    $this->app->render('register');
  }

  public function registerBtn()
  {
    session_start();
    $role = $_POST['inputRole'];

    switch ($role) {
      case 1:
        $success = baseController::registerAlumni();
        break;
      case 2:
        baseController::registerEmployer();
        break;
      case 3:
        baseController::registerFaculty();
        break;
    }

    if ($success) {
      $this->app->render('utils/successRegister');
    }
  }

  public function registerAlumni()
  {
    $email = strip_tags(Flight::request()->data->inputEmail);
    $passwordAlias = strip_tags(Flight::request()->data->inputPassword);
    $password = md5(strip_tags(Flight::request()->data->inputPassword));
    $firstName = strip_tags(Flight::request()->data->inputFName);
    $middleName = strip_tags(Flight::request()->data->inputMName);
    $lastName = strip_tags(Flight::request()->data->inputLName);
    $region = strip_tags(Flight::request()->data->region);
    $province = strip_tags(Flight::request()->data->province);
    $city = strip_tags(Flight::request()->data->municipality);
    $barangay = strip_tags(Flight::request()->data->barangay);
    $streetAddress = strip_tags(Flight::request()->data->StreetAdd);
    $cpNum = strip_tags(Flight::request()->data->inputCPNum);
    $bDate = strip_tags(Flight::request()->data->inputBDate);
    $sex = strip_tags(Flight::request()->data->inputSex);
    $alumniID = strip_tags(Flight::request()->data->inputSID);
    $created_at = date('Y-m-d H:i:s');

    $profilePic = ($sex == 1) ? 'images/profilepix/man_gen.jpg' :  'images/profilepix/lady_def.jpg';

    $db = Flight::db();
    $db->beginTransaction();

    try {
      $stmt1 = $db->prepare("INSERT INTO users (username, passAlias, password, role, is_verified, created_at) 
                           VALUES (:email, :passwordAlias, :password, 1, 0, :date)");

      if (!$stmt1->execute(['email' => $email, 'passwordAlias' => $passwordAlias, 'password' => $password, 'date' => $created_at])) {
        $errorInfo = $stmt1->errorInfo();
        throw new \Exception("First insertion failed. SQLSTATE: " . $errorInfo[0] . " Driver Error Code: " . $errorInfo[1] . " Driver Error Message: " . $errorInfo[2]);
      }

      $userId = $db->lastInsertId();

      $stmt2 = $db->prepare("INSERT INTO userdetails 
    (user_id, profile_pic_url, email_address, contact_number, first_name, middle_name, last_name, birth_date, sex, region, province, city, barangay, street_add) 
    VALUES 
    (:userId, :profilePic, :email, :contactNumber, :firstName, :middleName, :lastName, :birthDate, :sex, :region, :province, :city, :barangay, :streetAddress)");


      if (!$stmt2->execute(['userId' => $userId, 'email' => $email, 'profilePic' => $profilePic, 'contactNumber' => $cpNum, 'firstName' => $firstName, 'middleName' => $middleName, 'lastName' => $lastName, 'birthDate' => $bDate, 'sex' => $sex, 'region' => $region, 'province' => $province, 'city' => $city, 'barangay' => $barangay, 'streetAddress' => $streetAddress])) {
        throw new \Exception("Second insertion failed.");
      }

      $db->commit();
      return true;
    } catch (\Exception $e) {
      $db->rollBack();
      return false;
    }
  }

  public function registerEmployer() {}
  public function registerFaculty() {}

  public function login()
  {
    $invalid = false;
    $loggedVerified = false;
    $loggedUnverified = false;
    $this->app->render('login', [
      'invalid' => $invalid,
      'loggedVerified' => $loggedVerified,
      'loggedUnverified' => $loggedUnverified
    ]);
  }

  public function loginBtn()
  {
    session_start(); // Start the session if not already started

    $invalid = false;
    $loggedVerified = false;
    $loggedUnverified = false;

    $usernameUnsanitized = Flight::request()->data->inputUsernameLog;
    $username = strip_tags($usernameUnsanitized);
    $passinUnsanitized = Flight::request()->data->inputPasswordLog;
    $passin = strip_tags($passinUnsanitized);
    $passhash = md5($passin);

    $db = Flight::db();

    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username AND password = :passhash');

    $stmt->execute(['username' => $username, 'passhash' => $passhash]);

    $userl = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$userl) {
      $invalid = true;
    } else {
      $verified = $userl['is_verified'];

      if ($verified == 1) {
        //$person = $func->select_one('userdetails', ['user_id', '=', $userID]);

        $_SESSION['userid'] = $userl['id'];
        $_SESSION['username'] = $userl['username'];
        //$_SESSION['personid'] = $person[0]['person_id'];
        $_SESSION['role'] = $userl['role'];
        //$_SESSION['fullname'] = $person[0]['first_name'] . " " . $person[0]['last_name'];

        // Set role name
        switch ($_SESSION['role']) {
          case 4:
            $_SESSION['rolename'] = "Admin";
            break;
          case 3:
            $_SESSION['rolename'] = "Faculty";
            break;
          case 2:
            $_SESSION['rolename'] = "Employer";
            break;
          case 1:
            $_SESSION['rolename'] = "Alumni";
            break;
        }

        $loggedVerified = true;
      } else {
        $_SESSION['userid'] = $userl['id'];
        $_SESSION['role'] = $userl['role'];
        $loggedUnverified = true;
      }
    }

    if ($loggedVerified) {
      $_SESSION['login_success'] = true;
      switch ($_SESSION['rolename']) {
        case "Admin":
          $this->app->redirect(Flight::request()->base . '/dashboard/admin');
          break;
        case "Faculty":
          $this->app->redirect(Flight::request()->base . '/dashboard/faculty');
          break;
        case "Employer":
          $this->app->redirect(Flight::request()->base . '/dashboard/employer');
          break;
        case "Alumni":
          $this->app->redirect(Flight::request()->base . '/dashboard/alumni');
          break;
      }
    } else if ($loggedUnverified) {
      $_SESSION['login_unverified'] = true;
      $this->app->redirect(Flight::request()->base . '/verifying');
    }
    // Render the login view
    $this->app->render('login', [
      'invalid' => $invalid,
    ]);
  }

  public function getCompanies()
  {
    $db = Flight::db();

    $stmt = $db->prepare("SELECT * FROM companies ORDER BY name");
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public static function checkEmailExists($email)
  {
    $db = Flight::db();

    $stmt = $db->prepare("SELECT * FROM userdetails WHERE email_address = :email");
    $stmt->execute(['email' => $email]);
    $status = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $status;
  }

  public static function checkUsernameExists($username)
  {
    $db = Flight::db();

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $status = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $status;
  }
}
