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

class employerController
{
  protected Engine $app;

  public function __construct($app)
  {
    $this->app = $app;
  }

  public function index()
  {
    $_SESSION['employerPage'] = "dashboard";

    $this->app->render('employer/home', ['username' => $_SESSION['username']], 'home');
    Flight::render('header', [], 'header');
    Flight::render('employer/sidebar', [], 'sidebar');
  }

  public function createVacancy()
  {
    $_SESSION['employerPage'] = "createNewJob";

    $this->app->render('employer/createVacancy', ['username' => $_SESSION['username']], 'home');
    Flight::render('header', [], 'header');
    Flight::render('employer/sidebar', [], 'sidebar');
  }

  public function jobVacancies()
  {
    $_SESSION['employerPage'] = "jobVacancies";
    //$vacanciesData = $func->selectall_where('employer_job_posts', array('author_id', '=', $_SESSION['userid']));

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM employer_job_posts WHERE author_id = :user_id");
    $status = $stmt->execute(['user_id' => $_SESSION['userid']]);
    $vacanciesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set("vacanciesData", $vacanciesData);


    Flight::render('header', [], 'header');
    Flight::render('employer/sidebar', [], 'sidebar');
    Flight::render('employer/jobVacanciesData', [], 'jobVacanciesData');
    $this->app->render('employer/jobVacancies', ['username' => $_SESSION['username']], 'home');
  }

  public function renderTitle()
  {

    Flight::view()->set('title', 'hello');
  }

  public function jobVacanciesEdit()
  {
    $_SESSION['employerPage'] = "jobVacancies";
    //$vacanciesData = $func->selectall_where('employer_job_posts', array('author_id', '=', $_SESSION['userid']));

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM employer_job_posts WHERE author_id = :user_id");
    $status = $stmt->execute(['user_id' => $_SESSION['userid']]);
    $vacanciesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    bdump($vacanciesData);

    baseController::renderLocation($vacanciesData[0]['job_region'], $vacanciesData[0]['job_province'], $vacanciesData[0]['job_municipality'], $vacanciesData[0]['job_barangay']);
    Flight::view()->set("vacanciesData", $vacanciesData);
    Flight::render('header', [], 'header');
    Flight::render('employer/sidebar', [], 'sidebar');
    $this->app->render('employer/jobVacanciesEdit', ['username' => $_SESSION['username']], 'home');
  }

  public function editJobVacancy()
  {
    $position = strip_tags(Flight::request()->data->position);
    $numVacancies = strip_tags(Flight::request()->data->numVacancies);
    $locationCheckboxes = Flight::request()->data->locationCheckboxes;


    if ($locationCheckboxes) {
      if (in_array("regionCheckVal", $locationCheckboxes)) {
        $region = strip_tags(Flight::request()->data->regions);
      } else {
        $region = 0;
      }
      if (in_array("provinceCheckVal", $locationCheckboxes)) {
        $province = strip_tags(Flight::request()->data->provinces);
      } else {
        $province = 0;
      }
      if (in_array("municipalityCheckVal", $locationCheckboxes)) {
        $municipality = strip_tags(Flight::request()->data->municipalities);
      } else {
        $municipality = 0;
      }
      if (in_array("barangayCheckVal", $locationCheckboxes)) {
        $barangay = strip_tags(Flight::request()->data->barangays);
      } else {
        $barangay = 0;
      }
    } else {
      $region = 0;
      $province = 0;
      $municipality = 0;
      $barangay = 0;
    }

    $jobTypeCheckboxes = Flight::request()->data->jobTypeCheckboxes;
    $jobType = "000000";

    if ($jobTypeCheckboxes) {
      if (in_array("fullTime", $jobTypeCheckboxes)) {
        $isFullTime = true;
        $jobType[0] = '1';
      }
      if (in_array("partTime", $jobTypeCheckboxes)) {
        $isPartTime = true;
        $jobType[1] = '1';
      }
      if (in_array("contract", $jobTypeCheckboxes)) {
        $isContract = true;
        $jobType[2] = '1';
      }
      if (in_array("temporary", $jobTypeCheckboxes)) {
        $isTemporary = true;
        $jobType[3] = '1';
      }
      if (in_array("remote", $jobTypeCheckboxes)) {
        $isRemote = true;
        $jobType[4] = '1';
      }
      if (in_array("freelance", $jobTypeCheckboxes)) {
        $isFreelance = true;
        $jobType[5] = '1';
      }
    }

    $shift = strip_tags(Flight::request()->data->radioShift);
    $education = strip_tags(Flight::request()->data->radioEducation);
    $salaryFormat = strip_tags(Flight::request()->data->salaryFormat);

    if ($salaryFormat == "range") {
      $rangeSalaryMin = Flight::request()->data->rangeMin;
      $rangeSalaryMax = Flight::request()->data->rangeMax;
    } else if ($salaryFormat == "hour") {
      $hourlySalary = Flight::request()->data->phpHour;
    }

    $description = strip_tags(Flight::request()->data->jobDescription);

    if (!$shift) {
      $shift = "0";
    }

    if ($salaryFormat == "range") {
      $hourlySalary = "0";
    } else if ($salaryFormat == "hour") {
      $rangeSalaryMax = "0";
      $rangeSalaryMin = "0";
    } else {
      $rangeSalaryMax = "0";
      $rangeSalaryMin = "0";
      $hourlySalary = "0";
    }

    $db = Flight::db();
    switch ($salaryFormat) {
      case 'range':
        $stmt = $db->prepare("UPDATE employer_job_posts SET author_id = :author_id, education = :education, position = :position, slot_available = :slot_available, job_type = :job_type, job_shift = :job_shift, salary_format = :salary_format, salary_min = :salary_min, salary_max = :salary_max, job_description = :job_description, job_region = :job_region, job_province = :job_province, job_municipality = :job_municipality, job_barangay = :job_barangay WHERE job_id = :editSaveBtn");
        $status = $stmt->execute(['author_id' => $_SESSION['userid'], 'education' => $education, 'position' => $position, 'slot_available' => $numVacancies, 'job_type' => $jobType, 'job_shift' => $shift, 'salary_format' => $salaryFormat, 'salary_min' => $rangeSalaryMin, 'salary_max' => $rangeSalaryMax,  'job_description' => $description, 'job_region' => $region, 'job_province' => $province, 'job_municipality' => $municipality, 'job_barangay' => $barangay, 'editSaveBtn' => $_POST['editSaveBtn']]);
        break;
      case 'hour':
        $stmt = $db->prepare("UPDATE employer_job_posts SET author_id = :author_id, education = :education, position = :position, slot_available = :slot_available, job_type = :job_type, job_shift = :job_shift, salary_format = :salary_format, salary_hour = :salary_hour, job_description = :job_description, job_region = :job_region, job_province = :job_province, job_municipality = :job_municipality, job_barangay = :job_barangay WHERE job_id = :editSaveBtn");
        $status = $stmt->execute(['author_id' => $_SESSION['userid'], 'education' => $education, 'position' => $position, 'slot_available' => $numVacancies, 'job_type' => $jobType, 'job_shift' => $shift, 'salary_format' => $salaryFormat,  'salary_hour' => $hourlySalary, 'job_description' => $description, 'job_region' => $region, 'job_province' => $province, 'job_municipality' => $municipality, 'job_barangay' => $barangay, 'editSaveBtn' => $_POST['editSaveBtn']]);
        break;
      default:
        $stmt = $db->prepare("UPDATE employer_job_posts SET author_id = :author_id, education = :education, position = :position, slot_available = :slot_available, job_type = :job_type, job_shift = :job_shift, salary_format = :salary_format, job_description = :job_description, job_region = :job_region, job_province = :job_province, job_municipality = :job_municipality, job_barangay = :job_barangay WHERE job_id = :editSaveBtn");
        $status = $stmt->execute(['author_id' => $_SESSION['userid'], 'education' => $education, 'position' => $position, 'slot_available' => $numVacancies, 'job_type' => $jobType, 'job_shift' => $shift, 'salary_format' => $salaryFormat,  'job_description' => $description, 'job_region' => $region, 'job_province' => $province, 'job_municipality' => $municipality, 'job_barangay' => $barangay, 'editSaveBtn' => $_POST['editSaveBtn']]);
        break;
    }

    if ($status) {
      $_SESSION['jobVacancyCreated'] = true;
    }
    Flight::redirect(Flight::request()->base . '/dashboard/employer/jobVacancies');
  }

  public function createVacancySubmit()
  {
    $position = strip_tags(Flight::request()->data->position);
    $numVacancies = strip_tags(Flight::request()->data->numVacancies);
    $locationCheckboxes = Flight::request()->data->locationCheckboxes;

    bdump($locationCheckboxes);

    if ($locationCheckboxes) {
      if (in_array("regionCheckVal", $locationCheckboxes)) {
        $region = strip_tags(Flight::request()->data->regions);
      }
      if (in_array("provinceCheckVal", $locationCheckboxes)) {
        $province = strip_tags(Flight::request()->data->provinces);
      } else {
        $province = 0;
      }
      if (in_array("municipalityCheckVal", $locationCheckboxes)) {
        $municipality = strip_tags(Flight::request()->data->municipalities);
      } else {
        $municipality = 0;
      }
      if (in_array("barangayCheckVal", $locationCheckboxes)) {
        $barangay = strip_tags(Flight::request()->data->barangays);
      } else {
        $barangay = 0;
      }
    } else {
      $region = 0;
      $province = 0;
      $municipality = 0;
      $barangay = 0;
    }

    $jobTypeCheckboxes = Flight::request()->data->jobTypeCheckboxes;
    $jobType = "000000";

    if ($jobTypeCheckboxes) {
      if (in_array("fullTime", $jobTypeCheckboxes)) {
        $isFullTime = true;
        $jobType[0] = '1';
      }
      if (in_array("partTime", $jobTypeCheckboxes)) {
        $isPartTime = true;
        $jobType[1] = '1';
      }
      if (in_array("contract", $jobTypeCheckboxes)) {
        $isContract = true;
        $jobType[2] = '1';
      }
      if (in_array("temporary", $jobTypeCheckboxes)) {
        $isTemporary = true;
        $jobType[3] = '1';
      }
      if (in_array("remote", $jobTypeCheckboxes)) {
        $isRemote = true;
        $jobType[4] = '1';
      }
      if (in_array("freelance", $jobTypeCheckboxes)) {
        $isFreelance = true;
        $jobType[5] = '1';
      }
    }

    $shift = strip_tags(Flight::request()->data->radioShift);
    $education = strip_tags(Flight::request()->data->radioEducation);
    $salaryFormat = strip_tags(Flight::request()->data->salaryFormat);

    if ($salaryFormat == "range") {
      $rangeSalaryMin = Flight::request()->data->rangeMin;
      $rangeSalaryMax = Flight::request()->data->rangeMax;
    } else if ($salaryFormat == "hour") {
      $hourlySalary = Flight::request()->data->phpHour;
    }

    $description = strip_tags(Flight::request()->data->jobDescription);

    if (!$shift) {
      $shift = "0";
    }

    if ($salaryFormat == "range") {
      $hourlySalary = "0";
    } else if ($salaryFormat == "hour") {
      $rangeSalaryMax = "0";
      $rangeSalaryMin = "0";
    } else {
      $rangeSalaryMax = "0";
      $rangeSalaryMin = "0";
      $hourlySalary = "0";
    }

    $createdAt = date('Y-m-d');

    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO employer_job_posts (author_id, education, position, slot_available, job_type, job_shift, salary_format, salary_min, salary_max, salary_hour, job_description, job_region, job_province, job_municipality, job_barangay, created_at) VALUES (:author_id, :education, :position, :slot_available, :job_type, :job_shift, :salary_format, :salary_min, :salary_max, :salary_hour, :job_description, :job_region, :job_province ,:job_municipality, :job_barangay, :created_at)");
    $status = $stmt->execute(['author_id' => $_SESSION['userid'], 'education' => $education, 'position' => $position, 'slot_available' => $numVacancies, 'job_type' => $jobType, 'job_shift' => $shift, 'salary_format' => $salaryFormat, 'salary_min' => $rangeSalaryMin, 'salary_max' => $rangeSalaryMax, 'salary_hour' => $hourlySalary, 'job_description' => $description, 'job_region' => $region, 'job_province' => $province, 'job_municipality' => $municipality, 'job_barangay' => $barangay, 'created_at' => $createdAt]);

    if ($status) {
      $_SESSION['jobVacancyCreated'] = true;
    } else {
      $_SESSION['jobVacancyNotCreated'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/employer/createVacancy');
  }

  public function viewApps()
  {
    $_SESSION['employerPage'] = "jobVacancies";

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM applications WHERE application_post_id = :job_id");
    $status = $stmt->execute(['job_id' => $_GET['viewBtnVal']]);
    $appsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $appsInformation = [];

    foreach ($appsData as $appsDataInstance) {
      $stmt = $db->prepare('SELECT * FROM userdetails WHERE user_id = :application_alumni_id');
      $status = $stmt->execute(['application_alumni_id' => $appsDataInstance['application_alumni_id']]);
      $appsInformationUserdetails = $stmt->fetch(\PDO::FETCH_ASSOC);
      $name = $appsInformationUserdetails['last_name'] . ', ' . $appsInformationUserdetails['first_name'] . ', ' . $appsInformationUserdetails['middle_name'];
      //$name = $alumniInstance[0]['last_name'] . ', ' . $alumniInstance[0]['first_name'] . ' ' . $alumniInstance[0]['middle_name'];

      $stmt = $db->prepare('SELECT * FROM alumni_graduated_course WHERE user_id = :application_alumni_id');
      $status = $stmt->execute(['application_alumni_id' => $appsDataInstance['application_alumni_id']]);
      $appsInformationCourseID = $stmt->fetch(\PDO::FETCH_ASSOC);
      //$courseID = $func->select_one('alumni_graduated_course', array('user_id', '=', $appsDataInstance['application_alumni_id']));

      $stmt = $db->prepare('SELECT * FROM courses WHERE courseID = :courseID');
      $status = $stmt->execute(['courseID' => $appsInformationCourseID['course_id']]);
      $appsInformationCourse = $stmt->fetch(\PDO::FETCH_ASSOC);
      //$course = $func->select_one('courses', array('courseID', '=', $courseID[0]['course_id']));

      $stmt = $db->prepare('SELECT * FROM alumni_employment_status WHERE status_alumni_id = :application_alumni_id');
      $status = $stmt->execute(['application_alumni_id' => $appsDataInstance['application_alumni_id']]);
      $appsInformationStatus = $stmt->fetch(\PDO::FETCH_ASSOC);

      array_push(
        $appsInformation,
        array(
          "appsInformationCourse" => $appsInformationCourse,
          "appsInformationCourseID" => $appsInformationCourseID,
          "appsInformationStatus" => $appsInformationStatus,
          "appsInformationUserdetails" => $appsInformationUserdetails,
          "name" => $name,
        )
      );
    }



    Flight::view()->set("appsData", $appsData);
    Flight::view()->set("appsInformation", $appsInformation);
    Flight::render('header', [], 'header');
    Flight::render('employer/sidebar', [], 'sidebar');
    $this->app->render('employer/viewApps', ['username' => $_SESSION['username']], 'home');
    fopen(__DIR__ . '/../../public/assets/applicationFiles/670b3b8179e09_asynch_activity_ITSA01.pdf', 'r');
  }

  public function viewAppsInstance()
  {
    $file = $_GET['viewResumeBtn'];
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=filename.pdf");
    readfile($file);
    echo error_get_last();
  }

  public function deleteVacancy()
  {
    $jobID = $_GET['deleteVacancyBtn'];

    $db = Flight::db();
    $stmt = $db->prepare("DELETE FROM employer_job_posts WHERE job_id = :job_id");
    $status = $stmt->execute(['job_id' => $jobID]);

    Flight::redirect(Flight::request()->base . '/dashboard/employer/jobVacancies');
  }
}
