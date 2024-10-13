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


  public function addAward()
  {
    $awardName = strip_tags(Flight::request()->data->awardName);
    $awardDate = Flight::request()->data->awardDate;
    $awardInstitution = strip_tags(Flight::request()->data->awardInstitution);
    $awardDescription = strip_tags(Flight::request()->data->awardDescription);

    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO alumni_awards (alumni_userID, award_name, award_date, award_description, given_by) VALUES (:user_id, :awardName, :awardDate, :awardDescription, :awardInstitution)");
    $status = $stmt->execute(['user_id' => $_SESSION['userid'], 'awardName' => $awardName, 'awardDate' => $awardDate, 'awardInstitution' => $awardInstitution, 'awardDescription' => $awardDescription]);

    if ($status) {
      $_SESSION['awardAdded'] = true;
    } else {
      $_SESSION['awardNotAdded'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/awards');
  }

  public function editAward()
  {
    $awardID = strip_tags(Flight::request()->data->editAward);
    $awardName = strip_tags(Flight::request()->data->awardName);
    $awardDate = strip_tags(Flight::request()->data->awardDate);
    $awardInstitution = strip_tags(Flight::request()->data->awardInstitution);
    $awardDescription = strip_tags(Flight::request()->data->awardDescription);

    $db = Flight::db();
    $stmt = $db->prepare("UPDATE alumni_awards  set  award_name = :awardName, award_date = :awardDate, award_description = :awardDescription, given_by = :awardInstitution WHERE award_id = :awardID");
    $status = $stmt->execute(['awardID' => $awardID, 'awardName' => $awardName, 'awardDate' => $awardDate, 'awardInstitution' => $awardInstitution, 'awardDescription' => $awardDescription]);

    if ($status) {
      $_SESSION['awardEdited'] = true;
    } else {
      $_SESSION['awardNotEdited'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/awards');
  }

  public function deleteAward()
  {
    $awardID = strip_tags(Flight::request()->data->deleteAward);

    $db = Flight::db();
    $stmt = $db->prepare("DELETE FROM alumni_awards WHERE award_id = :awardID");
    $status = $stmt->execute(["awardID" => $awardID]);

    if ($status) {
      $_SESSION['awardDeleted'] = true;
    } else {
      $_SESSION['awardNotDeleted'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/awards');
  }

  public function workExp()
  {
    $_SESSION['alumniPage'] = "workExp";

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM alumni_work_experience WHERE owner_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniWorkData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set('alumniWorkData', $alumniWorkData);

    Flight::render('header', [], 'header');
    Flight::render('alumni/workExperienceRows', [], 'workExperienceRows');
    Flight::render('alumni/sidebar', [], 'sidebar');


    $this->app->render('alumni/workExperience', [
      'username' => $_SESSION['username'],
      'alumniWorkData' => $alumniWorkData
    ], 'home');
  }

  public function addWorkExp()
  {
    $institutionName = strip_tags(Flight::request()->data->institutionName);
    $position = strip_tags(Flight::request()->data->position);
    $startDate = strip_tags(Flight::request()->data->startDate);
    $endDate = strip_tags(Flight::request()->data->endDate);
    $workExpDescription = strip_tags(Flight::request()->data->workExpDescription);

    $db = Flight::db();
    $stmt = $db->prepare("INSERT INTO alumni_work_experience (owner_id, work_name, work_position, date_started, date_end, work_description) VALUES (:user_id, :institutionName, :position, :startDate, :endDate, :workExpDescription)");
    $status = $stmt->execute(['user_id' => $_SESSION['userid'], 'institutionName' => $institutionName, 'position' => $position, 'startDate' => $startDate, 'endDate' => $endDate, 'workExpDescription' => $workExpDescription]);

    if ($status) {
      $_SESSION['workExpAdded'] = true;
    } else {
      $_SESSION['workExpNotAdded'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/workExp');
  }

  public function editWorkExp()
  {
    $institutionName = strip_tags(Flight::request()->data->institutionName);
    $position = strip_tags(Flight::request()->data->position);
    $startDate = strip_tags(Flight::request()->data->startDate);
    $endDate = strip_tags(Flight::request()->data->endDate);
    $workExpDescription = strip_tags(Flight::request()->data->workExpDescription);

    $db = Flight::db();
    $stmt = $db->prepare("UPDATE alumni_work_experience set  work_name = :institutionName, work_position = :position, date_started = :startDate, date_end = :endDate,  work_description = :workExpDescription WHERE owner_id = :user_id");
    $status = $stmt->execute(['user_id' => $_SESSION['userid'], 'institutionName' => $institutionName, 'position' => $position, 'startDate' => $startDate, 'endDate' => $endDate, 'workExpDescription' => $workExpDescription]);

    if ($status) {
      $_SESSION['workExpEdited'] = true;
    } else {
      $_SESSION['workExpNotEdited'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/workExp');
  }

  public function deleteWorkExp()
  {
    $workExpID = Flight::request()->data->deleteWork;

    $db = Flight::db();
    $stmt = $db->prepare("DELETE from alumni_work_experience WHERE work_exp_id = :workExpID");
    $status = $stmt->execute(['workExpID' => $workExpID]);

    if ($status) {
      $_SESSION['workExpDeleted'] = true;
    } else {
      $_SESSION['workExpNotDeleted'] = true;
    }

    Flight::redirect(Flight::request()->base . '/dashboard/alumni/workExp');
  }

  public function submitApp()
  {
    if (isset($_POST['submitApp'])) {
      $targetDirectory = __DIR__ . "/../../public/assets/applicationFiles/";
      $uniqueID = uniqid();
      $targetFile = $targetDirectory . $uniqueID . "_" . basename($_FILES["formFile"]["name"]);

      $uploadOk = 1;


      $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
      if (file_exists($targetFile)) {
        $uploadOk = 0;
      }

      $allowedFileTypes = array("pdf");
      if (!in_array($fileType, $allowedFileTypes)) {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {
      } else {
        bdump(($_FILES["formFile"]["tmp_name"]));
        bdump($targetFile);
        if (move_uploaded_file($_FILES["formFile"]["tmp_name"], $targetFile)) {
          $db = Flight::db();
          $stmt = $db->prepare("INSERT  INTO applications (file_name, application_post_id, application_alumni_id) VALUES (:targetFile, :submitApp, :userid )");
          $status = $stmt->execute(["targetFile" => $targetFile, 'submitApp' => $_POST['submitApp'], 'userid' => $_SESSION['userid']]);

          $stmt = $db->prepare("INSERT INTO alumni_employment_status (status_post_id, status_alumni_id, employment_status) VALUES (:submitApp, :userid, 0)");
          $status = $stmt->execute(['submitApp' => $_POST['submitApp'], 'userid' => $_SESSION['userid']]);
        } else {
        }
      }
    }
  }

  public function bak()
  {
    $_SESSION['alumniPage'] = "workExp";

    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM alumni_work_experience WHERE owner_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniWorkData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set('alumniWorkData', $alumniWorkData);

    Flight::render('header', [], 'header');
    Flight::render('alumni/workExperienceRows', [], 'workExperienceRows');
    Flight::render('alumni/sidebar', [], 'sidebar');


    $this->app->render('alumni/workExperience', [
      'username' => $_SESSION['username'],
      'alumniWorkData' => $alumniWorkData
    ], 'home');
  }
}
