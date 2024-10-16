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
      $stmt1 = $db->prepare("INSERT INTO users (username, password, role, is_verified, created_at) 
                           VALUES (:email, :password, 1, 0, :date)");

      if (!$stmt1->execute(['email' => $email, 'password' => $password, 'date' => $created_at])) {
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

  public function announcements()
  {
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM announcements ORDER BY announcement_date DESC');
    $status = $stmt->execute();
    $announcementData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set('announcementData', $announcementData);

    $this->app->render('announcements');
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

      switch ($_SESSION['role']) {
        case "4":
          $this->app->redirect(Flight::request()->base . '/verifying/admin');
          break;
        case "3":
          $this->app->redirect(Flight::request()->base . '/verifying/faculty');
          break;
        case "2":
          $this->app->redirect(Flight::request()->base . '/verifying/employer');
          break;
        case "1":
          $this->app->redirect(Flight::request()->base . '/verifying/alumni');
          break;
      }
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
        $applyButtonRoute = Flight::request()->base . '/dashboard/employer/apply';
      } else if ($_SESSION['rolename'] == 'Alumni') {
        $_SESSION['alumniPage'] = "vacancies";
        $applyButtonRoute = Flight::request()->base . '/dashboard/alumni/apply';
      } else if ($_SESSION['rolename'] == 'Admin') {
        $_SESSION['adminPage'] = "vacancies";
        $applyButtonRoute = Flight::request()->base . '/dashboard/admin/apply';
      } else if ($_SESSION['rolename'] == 'Faculty') {
        $_SESSION['facultyPage'] = "vacancies";
        $applyButtonRoute = Flight::request()->base . '/dashboard/faculty/apply';
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
    } else if ($_SESSION['rolename'] == 'Admin') {
      Flight::render('admin/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == 'Faculty') {
      Flight::render('faculty/sidebar', [], 'sidebar');
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


    $stmt = $db->prepare("SELECT * FROM applications WHERE application_post_id = :job_id AND application_alumni_id = :userid");
    $status = $stmt->execute(["job_id" => $job_id, "userid" => $_SESSION['userid']]);
    if ($stmt->fetch(\PDO::FETCH_ASSOC)) {
      $alreadyApplied = true;
    } else {
      $alreadyApplied = false;
    }


    if ($_SESSION['rolename'] == "Alumni") {
      Flight::render('alumni/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Employer") {
      Flight::render('employer/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Faculty") {
      Flight::render('faculty/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Admin") {
      Flight::render('admin/sidebar', [], 'sidebar');
    } else if ($_SESSION['rolename'] == "Faculty") {
      Flight::render('faculty/sidebar', [], 'sidebar');
    }

    Flight::view()->set('alreadyApplied', $alreadyApplied);
    Flight::view()->set('dataInstance', $dataInstance);
    Flight::render('header', [], 'header');
    $this->app->render('apply', ['username' => $_SESSION['username']], 'home');
  }

  public static function renderLocation($region, $province, $municipality, $barangay)
  {
    Flight::view()->set('region', $region);
    Flight::view()->set('province', $province);
    Flight::view()->set('municipality', $municipality);
    Flight::view()->set('barangay', $barangay);
    Flight::render('locations', [], 'locations');
  }

  public function viewProfile()
  {
    $profileID = $_POST['profile'];
    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM userdetails LEFT JOIN alumni_graduated_course ON userdetails.user_id = alumni_graduated_course.user_id JOIN campuses ON alumni_graduated_course.campus = campuses.campusID JOIN courses ON alumni_graduated_course.course_id = courses.courseID JOIN coursesmajor ON alumni_graduated_course.major_id = coursesmajor.major_id WHERE userdetails.user_id = :profileID');
    $status = $stmt->execute(['profileID' => $profileID]);
    $profileData = $stmt->fetch(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT * FROM alumni_awards WHERE alumni_userID = :profileID');
    $status = $stmt->execute(['profileID' => $profileID]);
    $profileAwards = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT * FROM alumni_work_experience WHERE owner_id =  :profileID');
    $status = $stmt->execute(['profileID' => $profileID]);
    $profileWorkExp = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if ($_SESSION['rolename'] == "Employer") {
      Flight::render('employer/sidebar', [], 'sidebar');
    }

    bdump($profileData);
    bdump($profileAwards);
    bdump($profileWorkExp);
    Flight::view()->set('profileData', $profileData);
    Flight::view()->set('profileAwards', $profileAwards);
    Flight::view()->set('profileWorkExp', $profileWorkExp);

    Flight::render('header', [], 'header');
    $this->app->render('viewProfile', ['username' => $_SESSION['username']], 'home');
  }

  public function verifyingAlumni()
  {
    session_start();

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM companies');
    $status = $stmt->execute();


    if ($_SESSION['role'] == 1) {
      $stmt = $db->prepare("SELECT * FROM users LEFT JOIN userdetails ON users.id =  userdetails.user_id LEFT JOIN alumni_graduated_course ON userdetails.user_id = alumni_graduated_course.user_id WHERE users.id = :userid");
      $status = $stmt->execute(['userid' => $_SESSION['userid']]);
      $alumniData = $stmt->fetch(\PDO::FETCH_ASSOC);

      $stmt = $db->prepare('SELECT * FROM courses');
      $status = $stmt->execute();
      $courses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      $stmt = $db->prepare('SELECT * FROM campuses');
      $status = $stmt->execute();
      $campuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      $stmt = $db->prepare('SELECT * FROM coursesmajor');
      $status = $stmt->execute();
      $majors = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      $mapMajors = array_combine(array_column($majors, 'majorName'), array_column($majors, 'major_id'));

      Flight::view()->set('alumniData', $alumniData);
      Flight::view()->set('campuses', $campuses);
      Flight::view()->set('courses', $courses);
      Flight::view()->set('majors', $majors);
      Flight::view()->set('mapMajors', $mapMajors);
    }

    bdump($alumniData);

    baseController::renderLocation($alumniData['region'], $alumniData['province'], $alumniData['city'], $alumniData['barangay']);

    $this->app->render('verifyingAlumni');
  }

  public function verifyingAlumniSave()
  {
    session_start();

    if ($_SESSION['role'] == 1) {
      $email = strip_tags($_POST['alumniEmail']);
      $username = strip_tags($_POST['alumniUsername']);
      $firstName = strip_tags($_POST['alumniFName']);
      $middleName = strip_tags($_POST['alumniMName']);
      $lastName = strip_tags($_POST['alumniLName']);
      $suffix = strip_tags($_POST['alumniSuffix']);
      $region = strip_tags($_POST['regions'] ?? "0");
      $province = strip_tags($_POST['provinces'] ?? "0");
      $municipality = strip_tags($_POST['municipalities'] ?? "0");
      $barangay = strip_tags($_POST['barangays'] ?? "0");
      $streetAdd = strip_tags($_POST['alumniStAdd']);
      $contactNumber = strip_tags($_POST['alumniCPNumber']);
      $birthDate = strip_tags($_POST['alumniBDate']);
      $studentId = strip_tags($_POST['alumniStudId']);
      $course = strip_tags($_POST['alumniCourse']);
      $major = strip_tags($_POST['alumniMajor']);
      $campus = strip_tags($_POST['alumniCampus']);
      $yearGraduated = strip_tags($_POST['alumniGraduated']);
      $yearEnrolled = strip_tags($_POST['alumniEnrolled']);

      $db = Flight::db();
      $stmt = $db->prepare('SELECT * FROM userdetails WHERE email_address = :email');
      $status = $stmt->execute(['email' => $email]);
      $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      } else {
        if ($selectUser) {
          if (!($selectUser['user_id'] == $_SESSION['userid'])) {
            $debug = $selectUser['user_id'];
            $debug2 = $_SESSION['userid'];
            $emailErrExists = true;
          }
        } else {
          $stmt = $db->prepare('UPDATE userdetails SET email_address = :email_address WHERE user_id = :userid');
          $status = $stmt->execute(['email_address' => $email, 'userid' => $_SESSION['userid']]);
        }
      }

      $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
      $status = $stmt->execute(['username' => $username]);
      $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

      if ($selectUser) {
        if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
          $usernameErr = true;
        }
      } else {
        $stmt = $db->prepare('UPDATE users SET username = :username WHERE id = :userid');
        $status = $stmt->execute(['username' => $username, 'userid' => $_SESSION['userid']]);
      }

      $stmt = $db->prepare('UPDATE userdetails SET contact_number = :contactNumber, first_name = :firstName, middle_name = :middleName, birth_date = :birthDate, region = :region, province = :province, city = :municipality, barangay = :barangay, street_add = :streetAdd, suffix = :suffix, last_name = :lastName  WHERE user_id = :userid');
      $status = $stmt->execute(['contactNumber' => $contactNumber, 'firstName' => $firstName, 'middleName' => $middleName, 'birthDate' => $birthDate, 'region' => $region, 'province' => $province, 'municipality' => $municipality, 'barangay' => $barangay, 'streetAdd' => $streetAdd, 'suffix' => $suffix,  'userid' => $_SESSION['userid'], 'lastName' => $lastName]);

      $stmt = $db->prepare('SELECT * FROM coursesmajor');
      $status = $stmt->execute();
      $majors = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      $mapMajors = array_combine(array_column($majors, 'majorName'), array_column($majors, 'major_id'));

      $stmt = $db->prepare('UPDATE alumni_graduated_course SET course_id = :course, campus = :campus, studnum = :studentId, major_id = :major, year_started = :yearEnrolled, year_graduated = :yearGraduated WHERE user_id = :userid');
      $updateDetails3 = $stmt->execute(['course' => $course, 'campus' => $campus, 'studentId' => $studentId, 'major' => $mapMajors[$major], 'yearEnrolled' => $yearEnrolled, 'yearGraduated' => $yearGraduated, 'userid' => $_SESSION['userid']]);

      if (!$updateDetails3) {
        $stmt = $db->prepare('SELECT * FROM alumni_graduated_course WHERE user_id = :userid');
        $alumni_grad_table_exist = $stmt->execute(['userid' => $_SESSION['userid']]);


        if (!$alumni_grad_table_exist) {
          $stmt = $db->prepare('INSERT INTO alumni_graduated_course 
                              (course_id, campus, studnum, major_id, year_started, year_graduated, user_id) 
                              VALUES 
                              (:course, :campus, :studentId, :major, :yearEnrolled, :yearGraduated, :userid)
                              ');
          $updateDetails3 = $stmt->execute(['course_id' => $course, 'campus' => $campus, 'studentId' => $studentId, 'major' => $mapMajors[$major], 'yearEnrolled' => $yearEnrolled, 'yearGraduated' => $yearGraduated, 'userid' => $_SESSION['userid']]);
        }
      }
    }
    Flight::redirect(Flight::request()->base . '/verifying/alumni');
  }

  public function verifyingFacultySave()
  {
    session_start();

    $email = strip_tags($_POST['facultyEmail']);
    $username = strip_tags($_POST['facultyUsername']);
    $firstName = strip_tags($_POST['facultyFName']);
    $middleName = strip_tags($_POST['facultyMName']);
    $lastName = strip_tags($_POST['facultyLName']);
    $suffix = strip_tags($_POST['facultySuffix']);
    $region = strip_tags($_POST['regions'] ?? '0');
    $province = strip_tags($_POST['provinces'] ?? '0');
    $municipality = strip_tags($_POST['municipalities'] ?? '0');
    $barangay = strip_tags($_POST['barangays'] ?? '0');
    $streetAdd = strip_tags($_POST['facultyStAdd']);
    $contactNumber = strip_tags($_POST['facultyCPNumber']);
    $birthDate = strip_tags($_POST['facultyBDate']);
    $campus = strip_tags($_POST['facultyCampus']);
    $facultyID = strip_tags($_POST['facultyID']);
    $acadRank = strip_tags($_POST['facultyRank']);

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM userdetails WHERE email_address = :email');
    $status = $stmt->execute(['email' => $email]);
    $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    } else {
      if ($selectUser) {
        if (!($selectUser['user_id'] == $_SESSION['userid'])) {
          $debug = $selectUser['user_id'];
          $debug2 = $_SESSION['userid'];
          $emailErrExists = true;
        }
      } else {
        $stmt = $db->prepare('UPDATE userdetails SET email_address = :email_address WHERE user_id = :userid');
        $status = $stmt->execute(['email_address' => $email, 'userid' => $_SESSION['userid']]);
      }
    }

    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $status = $stmt->execute(['username' => $username]);
    $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($selectUser) {
      if (!($selectUser['id'] == $_SESSION['userid'])) {
        $usernameErr = true;
      }
    } else {
      $stmt = $db->prepare('UPDATE users SET username = :username WHERE id = :userid');
      $status = $stmt->execute(['username' => $username, 'userid' => $_SESSION['userid']]);
    }

    $stmt = $db->prepare('UPDATE userdetails SET contact_number = :contactNumber, first_name = :firstName, middle_name = :middleName, birth_date = :birthDate, region = :region, province = :province, city = :municipality, barangay = :barangay, street_add = :streetAdd, suffix = :suffix, last_name = :lastName  WHERE user_id = :userid');
    $status = $stmt->execute(['contactNumber' => $contactNumber, 'firstName' => $firstName, 'middleName' => $middleName, 'birthDate' => $birthDate, 'region' => $region, 'province' => $province, 'municipality' => $municipality, 'barangay' => $barangay, 'streetAdd' => $streetAdd, 'suffix' => $suffix,  'userid' => $_SESSION['userid'], 'lastName' => $lastName]);

    $stmt = $db->prepare('UPDATE faculty SET campus_id = :campus, acadrank_id = :acadRank, employee_num = :facultyID');
    $updateDetails3 = $stmt->execute(['campus' => $campus, 'acadRank' => $acadRank, 'facultyID' => $facultyID]);

    if (!$updateDetails3) {
      $stmt = $db->prepare('SELECT * FROM faculty WHERE user_id = :userid');
      $faculty_exists = $stmt->execute(['userid' => $_SESSION['userid']]);
      if (!$faculty_exists) {
        $stmt = $db->prepare('INSERT INTO faculty (user_id, campus_id, acadrank_id, employee_num) VALUES (:userid, :campus, :acadRank, :facultyID)');
        $status = $stmt->execute(['userid' => $_SESSION['userid'], 'campus' => $campus, 'acadRank' => $acadRank, 'facultyID' => $facultyID]);
      }
    }
    Flight::redirect(Flight::request()->base . '/verifying/faculty');
  }


  public function verifyingFaculty()
  {
    session_start();

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM campuses');
    $status = $stmt->execute();
    $campuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM faculty_rankings');
    $status = $stmt->execute();
    $acadRanks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM users LEFT JOIN userdetails ON users.id = userdetails.user_id LEFT JOIN faculty ON userdetails.user_id = faculty.user_id WHERE users.id = :userid');
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $facultyData = $stmt->fetch(\PDO::FETCH_ASSOC);

    Flight::view()->set('campuses', $campuses);
    Flight::view()->set('acadRanks', $acadRanks);
    Flight::view()->set('facultyData', $facultyData);

    bdump($facultyData);

    baseController::renderLocation($facultyData['region'] ?? '0', $facultyData['province'] ?? '0', $facultyData['city'] ?? '0', $facultyData['barangay'] ?? '0');

    $this->app->render('verifyingFaculty');
  }

  public function verifyingEmployer()
  {
    session_start();

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM companies');
    $status = $stmt->execute();
    $companies = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT * FROM users LEFT JOIN userdetails ON users.id = userdetails.user_id LEFT JOIN employer_users ON userdetails.user_id = employer_users.user_id WHERE users.id = :userid');
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $employerData = $stmt->fetch(\PDO::FETCH_ASSOC);

    Flight::view()->set('companies', $companies);
    Flight::view()->set('employerData', $employerData);


    bdump($employerData);
    baseController::renderLocation($employerData['region'], $employerData['province'], $employerData['city'], $employerData['barangay']);

    $this->app->render('verifyingEmployer');
  }

  public function verifyingEmployerSave()
  {
    session_start();

    $email = strip_tags($_POST['employerEmail']);
    $username = strip_tags($_POST['employerUsername']);
    $firstName = strip_tags($_POST['employerFName']);
    $middleName = strip_tags($_POST['employerMName']);
    $lastName = strip_tags($_POST['employerLName']);
    $suffix = strip_tags($_POST['employerSuffix']);
    $region = strip_tags($_POST['regions'] ?? '0');
    $province = strip_tags($_POST['provinces'] ?? '0');
    $municipality = strip_tags($_POST['municipalities'] ?? '0');
    $barangay = strip_tags($_POST['barangays'] ?? '0');
    $streetAdd = strip_tags($_POST['employerStAdd']);
    $contactNumber = strip_tags($_POST['employerCPNumber']);
    $birthDate = strip_tags($_POST['employerBDate']);
    $companyName = strip_tags($_POST['employerCompany']);

    if ($companyName == "0") {
      $companyName2 = strip_tags($_POST['employerCompanySTR']);
    } else {
      $companyName2 = '';
    }

    $position = strip_tags($_POST['employerPosition']);

    $db = Flight::db();
    $stmt = $db->prepare('SELECT * FROM userdetails WHERE email_address = :email');
    $status = $stmt->execute(['email' => $email]);
    $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    } else {
      if ($selectUser) {
        if (!($selectUser['user_id'] == $_SESSION['userid'])) {
          $debug = $selectUser['user_id'];
          $debug2 = $_SESSION['userid'];
          $emailErrExists = true;
        }
      } else {
        $stmt = $db->prepare('UPDATE userdetails SET email_address = :email_address WHERE user_id = :userid');
        $status = $stmt->execute(['email_address' => $email, 'userid' => $_SESSION['userid']]);
      }
    }

    $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
    $status = $stmt->execute(['username' => $username]);
    $selectUser  = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($selectUser) {
      if (!($selectUser['id'] == $_SESSION['userid'])) {
        $usernameErr = true;
      }
    } else {
      $stmt = $db->prepare('UPDATE users SET username = :username WHERE id = :userid');
      $status = $stmt->execute(['username' => $username, 'userid' => $_SESSION['userid']]);
    }

    $stmt = $db->prepare('UPDATE userdetails SET contact_number = :contactNumber, first_name = :firstName, middle_name = :middleName, birth_date = :birthDate, region = :region, province = :province, city = :municipality, barangay = :barangay, street_add = :streetAdd, suffix = :suffix, last_name = :lastName  WHERE user_id = :userid');
    $status = $stmt->execute(['contactNumber' => $contactNumber, 'firstName' => $firstName, 'middleName' => $middleName, 'birthDate' => $birthDate, 'region' => $region, 'province' => $province, 'municipality' => $municipality, 'barangay' => $barangay, 'streetAdd' => $streetAdd, 'suffix' => $suffix,  'userid' => $_SESSION['userid'], 'lastName' => $lastName]);


    if ($companyName2 != '') {
      $stmt = $db->prepare('UPDATE employer_users SET company_unvalidated = :companyName2, company_id = 0, company_position = :position WHERE user_id = :userid');
      $updateDetails3 = $stmt->execute(['companyName2' => $companyName2, 'position' => $position, 'userid' => $_SESSION['userid']]);

      if (!$updateDetails3) {
        $stmt = $db->prepare('SELECT * FROM employer_users WHERE user_id = :userid');
        $employer_users_exists = $stmt->execute(['userid' => $_SESSION['userid']]);

        if (!$employer_users_exists) {
          $stmt = $db->prepare('INSERT INTO employer_users (user_id, company_unvalidated, company_id, company_position) VALUES (:userid, :unvalidated, 0, :position)');
          $status = $stmt->execute(['userid' => $_SESSION['userid'], 'unvalidated' => $companyName2, 'position' => $position]);
        }
      }
    } else {
      $stmt = $db->prepare('UPDATE employer_users SET company_id = :companyName, company_position = :position WHERE user_id = :userid');
      $updateDetails3 = $stmt->execute(['companyName' => $companyName, 'position' => $position, 'userid' => $_SESSION['userid']]);

      if (!$updateDetails3) {
        $stmt = $db->prepare('SELECT * FROM employer_users WHERE user_id = :userid');
        $employer_users_exists = $stmt->execute(['userid' => $_SESSION['userid']]);

        if (!$employer_users_exists) {
          $stmt = $db->prepare('INSERT INTO employer_users (user_id, company_id, company_position) VALUES (:userid, :companyName, :position)');
          $status = $stmt->execute(['userid' => $_SESSION['userid'], 'companyName' => $companyName, 'position' => $position]);
        }
      }
    }

    Flight::redirect(Flight::request()->base . '/verifying/employer');
  }
}
