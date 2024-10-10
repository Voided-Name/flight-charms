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

  public function allVacancies()
  {
    if (isset($_SESSION['rolename'])) {
      if ($_SESSION['rolename'] == 'Employer') {
        $_SESSION['employerPage'] = "allVacancies";
        $applyButtonRoute = Flight::request()->base . '/dashboard/employer/viewApply';
      } else if ($_SESSION['rolename'] == 'Alumni') {
        $_SESSION['alumniPage'] = "vacancies";
        $applyButtonRoute = Flight::request()->base . '/dashboard/alumni/apply';
      }
    }

    if (!isset($_SESSION['vacancyPage'])) {
      $_SESSION['vacancyPage'] = 0;
    }

    if (isset($_GET['page'])) {
      $_SESSION['vacancyPage'] = $_GET['page'];
    }

    bdump($_SESSION['vacancyPage']);

    $offset = $_SESSION['vacancyPage'] * 5;

    if (isset($_GET['applyFilters'])) {
      $filterData = array(
        isset($_GET['locationCheckboxes']) ? $_GET['locationCheckboxes'] : '',
        isset($_GET['jobTypeCheckboxes']) ? $_GET['jobTypeCheckboxes'] : '',
        isset($_GET['radioShift']) ? $_GET['radioShift'] : '',
        isset($_GET['radioEducation']) ? $_GET['radioEducation'] : ''
      );
      $locationFilters = array('', '', '', '');
      $jobTypeFilters = $filterData[1];

      if ($filterData[0] != '') {
        if (in_array('regionCheckVal', $filterData[0])) {
          $locationFilters[0] = $_GET['regions'];
        }
        if (in_array('provinceCheckVal', $filterData[0])) {
          $locationFilters[1] = $_GET['provinces'];
        }
        if (in_array('municipalityCheckVal', $filterData[0])) {
          $locationFilters[2] = $_GET['municipalities'];
        }
        if (in_array('municipalityCheckVal', $filterData[0])) {
          $locationFilters[3] = $_GET['barangays'];
        }
        $_SESSION['locationFilters'] = $locationFilters;
      } else {
        $_SESSION['locationFilters'] = '';
      }

      if ($filterData[1] != '') {
        $_SESSION['jobTypeFilters'] = $jobTypeFilters;
      } else {
        $_SESSION['jobTypeFilters'] = '';
      }
      if ($filterData[2] != '') {
        $_SESSION['shiftFilter'] = $filterData[2];
      } else {
        $_SESSION['shiftFilter'] = '';
      }
      if ($filterData[3] != '') {
        $_SESSION['educFilter'] = $filterData[3];
      } else {
        $_SESSION['educFilter'] = '';
      }

      $_SESSION['vacancyPage'] = 0;
      $offset = 0;
    }

    if (isset($_SESSION['locationFilters'])) {
      $locationFiltersSql = "";
      $locationFilters = $_SESSION['locationFilters'];
      $args = 0;

      if ($locationFilters) {
        if ($locationFilters[0] != '') {
          if ($args == 0) {
            $locationFiltersSql .= "WHERE employer_job_posts.job_region = '" . $locationFilters[0] . "'";
            $args = 1;
          } else {
            $locationFiltersSql .= " AND employer_job_posts.job_region = '" . $locationFilters[0] . "'";
          }
        }
        if ($locationFilters[1] != '') {
          if ($args == 0) {
            $locationFiltersSql .= "WHERE employer_job_posts.job_province= '" . $locationFilters[1] . "'";
            $args = 1;
          }
          $locationFiltersSql .= " AND employer_job_posts.job_province= '" . $locationFilters[1] . "'";
        }
        if ($locationFilters[2] != '') {
          if ($args == 0) {
            $locationFiltersSql .= "WHERE employer_job_posts.job_municipality= '" . $locationFilters[2] . "'";
            $args = 1;
          } else {
            $locationFiltersSql .= "AND employer_job_posts.job_municipality = '" . $locationFilters[2] . "'";
          }
        }
        if ($locationFilters[3] != '') {
          if ($args == 0) {
            $locationFiltersSql .= "WHERE employer_job_posts.job_barangay = '" . $locationFilters[3] . "'";
            $args = 1;
          }
          $locationFiltersSql .= " AND employer_job_posts.job_barangay = '" . $locationFilters[3] . "'";
        }
      }
    }


    if (isset($_SESSION['jobTypeFilters'])) {
      $jobTypeFiltersSql = '';
      $jobTypeFilters = $_SESSION['jobTypeFilters'];
      $_SESSION['jobTypeFilters'] = $jobTypeFilters;


      if ($jobTypeFilters) {
        if (in_array('fullTime', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "1_____'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "1_____";
          }
        }
        if (in_array('partTime', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "_1____'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "_1____";
          }
        }
        if (in_array('contract', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "__1___'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "__1___";
          }
        }
        if (in_array('temporary', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "___1__'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "___1__";
          }
        }
        if (in_array('remote', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "____1_'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "____1_";
          }
        }
        if (in_array('freelance', $jobTypeFilters)) {
          if ($args == 0) {
            $jobTypeFiltersSql .= "WHERE employer_job_posts.job_type LIKE '" . "_____1'";
            $args = 1;
          } else {
            $jobTypeFiltersSql .= " AND employer_job_posts.job_type LIKE '" . "_____1";
          }
        }
      }
    }


    if (isset($_SESSION['shiftFilter'])) {
      $shiftFilterSql = '';
      $shiftFilter = $_SESSION['shiftFilter'];

      if ($shiftFilter) {
        switch ($shiftFilter) {
          case '1':
            if ($args == 0) {
              $shiftFilterSql .= 'WHERE employer_job_posts.job_shift = 1';
              $args = 1;
            } else {
              $shiftFilterSql .= ' AND employer_job_posts.job_shift = 1';
            }
            break;
          case '2':
            if ($args == 0) {
              $shiftFilterSql .= 'WHERE employer_job_posts.job_shift = 2';
              $args = 1;
            } else {
              $shiftFilterSql .= ' AND employer_job_posts.job_shift = 2';
            }
            break;
          case '3':
            if ($args == 0) {
              $shiftFilterSql .= 'WHERE employer_job_posts.job_shift = 3';
              $args = 1;
            } else {
              $shiftFilterSql .= ' AND employer_job_posts.job_shift = 3';
            }
            break;
          case '4':
            if ($args == 0) {
              $shiftFilterSql .= 'WHERE employer_job_posts.job_shift = 4';
              $args = 1;
            } else {
              $shiftFilterSql .= ' AND employer_job_posts.job_shift = 4';
            }
            break;
          case '5':
            if ($args == 0) {
              $shiftFilterSql .= 'WHERE employer_job_posts.job_shift = 5';
              $args = 1;
            } else {
              $shiftFilterSql .= ' AND employer_job_posts.job_shift = 5';
            }
            break;
        }
      }
    }

    if (isset($_SESSION['educFilter'])) {
      $educFilterSql = '';
      $educFilter = $_SESSION['educFilter'];

      if ($educFilter) {
        switch ($educFilter) {
          case '1':
            if ($args == 0) {
              $educFilterSql .= 'WHERE employer_job_posts.education = 1';
              $args = 1;
            } else {
              $educFilterSql .= ' AND employer_job_posts.education = 1';
            }
            break;
          case '2':
            if ($args == 0) {
              $educFilterSql .= 'WHERE employer_job_posts.education = 2';
              $args = 1;
            } else {
              $educFilterSql .= ' AND employer_job_posts.education = 2';
            }
            break;
          case '3':
            if ($args == 0) {
              $educFilterSql .= 'WHERE employer_job_posts.education = 3';
              $args = 1;
            } else {
              $educFilterSql .= ' AND employer_job_posts.education = 3';
            }
            break;
          case '4':
            if ($args == 0) {
              $educFilterSql .= 'WHERE employer_job_posts.education = 4';
              $args = 1;
            } else {
              $educFilterSql .= ' AND employer_job_posts.education = 4';
            }
            break;
        }
      }
    }

    $filters = '';
    if (isset($_SESSION['locationFilter'])) {
      $filters .= $locationFiltersSql;
    }
    if (isset($_SESSION['jobTypeFilters'])) {
      $filters .= $jobTypeFiltersSql;
    }
    if (isset($_SESSION['shiftFilter'])) {
      $filters .= $shiftFilterSql;
    }
    if (isset($_SESSION['educFilter'])) {
      $filters .= $educFilterSql;
    }

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM employer_job_posts LEFT JOIN employer_users ON employer_job_posts.author_id = employer_users.user_id LEFT JOIN companies ON employer_users.company_id = companies.company_id " . $filters . "LIMIT 6 OFFSET " . $offset);
    $status = $stmt->execute();

    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $stmt = $db->prepare("SELECT COUNT(*) as total_count FROM employer_job_posts LEFT JOIN employer_users ON employer_job_posts.author_id = employer_users.user_id LEFT JOIN companies ON employer_users.company_id = companies.company_id " . $filters);
    $status = $stmt->execute();
    $dataCount = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$dataCount) {
      $dataCount = 0;
    } else {
      $dataCount = $dataCount['total_count'];
    }


    Flight::view()->set('applyButtonRoute', $applyButtonRoute);
    Flight::view()->set('data', $data);
    Flight::view()->set('dataCount', $dataCount);

    Flight::render('header', [], 'header');
    if ($_SESSION['rolename'] == 'Employer') {
      Flight::render('employer/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Alumni") {
      Flight::render('alumni/sidebar', [], 'sidebar');
    }
    Flight::render('allVacanciesPagination', [], 'allVacanciesPagination');
    Flight::render('allVacanciesCard', [], 'allVacanciesCard');
    $this->app->render('allVacancies', ['username' => $_SESSION['username']], 'home');
  }

  public function vacancyPagination()
  {
    $pageNum = $_SESSION['vacancyPage'];

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page === "next") {
          $pageNum += 1;
        } else if ($page === "previous") {
          $pageNum -= 1;
        }
      }
    }


    if ($_SESSION['rolename'] == "Employer") {
      Flight::redirect(Flight::request()->base . "/dashboard/employer/allVacancies?page=" . $pageNum);
    } else if ($_SESSION['rolename'] == "Alumni") {
      Flight::redirect(Flight::request()->base . "/dashboard/alumni/allVacancies?page=" . $pageNum);
    }
  }

  public function apply()
  {
    $job_id = $_GET['applyButton'];
    //$dataInstance = $func->selectjoin3_where('employer_job_posts', 'employer_users', 'companies', 'author_id', 'user_id', 'company_id', 'id', 'employer_job_posts', array('post_id', '=', $_SESSION['applyId']));
    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM employer_job_posts JOIN employer_users ON employer_job_posts.author_id = employer_users.user_id JOIN companies ON employer_users.company_id = companies.company_id WHERE job_id = :job_id");
    $status = $stmt->execute(["job_id" => $job_id]);
    $dataInstance = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($_SESSION['rolename'] == "Alumni") {
      Flight::render('alumni/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Employer") {
      Flight::render('employer/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Faculty") {
      Flight::render('faculty/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Admin") {
      Flight::render('admin/sidebar', [], 'sidebar');
    }

    Flight::view()->set('dataInstance', $dataInstance);
    Flight::render('header', [], 'header');
    $this->app->render('apply', ['username' => $_SESSION['username']], 'home');
  }
}
