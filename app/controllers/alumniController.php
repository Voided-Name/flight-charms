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

require_once __DIR__ . '/../fpdf/fpdf.php';


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

  public function generateResume()
  {
    $_SESSION['alumniPage'] = "genResume";
    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM userdetails WHERE user_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_graduated_course WHERE user_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniCourseDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_awards WHERE alumni_userID = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniAwards = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_work_experience WHERE owner_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniWorkExperience = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    Flight::view()->set('alumniDetails', $alumniDetails);
    Flight::view()->set('alumniCourseDetails', $alumniCourseDetails);
    Flight::view()->set('alumniWorkExperience', $alumniWorkExperience);
    Flight::view()->set('alumniAwards', $alumniAwards);


    Flight::render('header', [], 'header');
    Flight::render('alumni/sidebar', [], 'sidebar');

    $this->app->render('alumni/generateResume', ['username' => $_SESSION['username']], 'home');
  }

  public function generateResumePDF()
  {
    $db = Flight::db();
    $stmt = $db->prepare("SELECT * FROM userdetails WHERE user_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_graduated_course WHERE user_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniCourseDetails = $stmt->fetch(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_awards WHERE alumni_userID = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniAwards = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT * FROM alumni_work_experience WHERE owner_id = :userid");
    $status = $stmt->execute(['userid' => $_SESSION['userid']]);
    $alumniWorkExperience = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $alumniAwardIDs = array();
    $alumniAwardIDs = $_POST['awardCheckbox'] ?? '';

    $alumniWorkIDs = array();
    $alumniWorkIDs = $_POST['experienceCheckbox'] ?? '';

    if ($alumniAwardIDs == '' && $alumniWorkIDs == '') {
      Flight::redirect(Flight::request()->base . "/dashboard/alumni/generateResume");
      exit();
    }

    // Create instance of FPDF class
    $pdf = new \FPDF();

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Courier', 'B', 16);

    $pageWidth = $pdf->GetPageWidth();
    $leftMargin = $pdf->GetX(); // Default left margin
    $rightMargin = $leftMargin; // Default right margin
    $cellWidth = $pageWidth - $leftMargin - $rightMargin;

    // Add a cell
    $pdf->Cell($cellWidth, 0, 'Resume', 0, 2, 'C', false);

    $lineY = $pdf->GetY() + 5;

    $pdf->Line($leftMargin, $lineY, $pageWidth - $rightMargin, $lineY);

    $pdf->Ln(10);

    // name
    $name = $alumniDetails['last_name'] . ', ' . $alumniDetails['first_name'] . ' ' . $alumniDetails['middle_name'];
    $pdf->SetFont('Courier', 'B', 11);
    $pdf->Cell(20, 0, "Name: ", 0, 0, 'L', false);
    $pdf->SetFont('Courier', '', 11);
    $pdf->Cell($cellWidth, 0, $name, 0, 2, 'L', false);
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Ln(5);

    // details
    $email = $alumniDetails['email_address'];
    $pdf->SetFont('Courier', 'B', 11);
    $pdf->Cell(20, 0, "Email: ", 0, 0, 'L', false);
    $pdf->SetFont('Courier', '', 11);
    $pdf->Cell($cellWidth, 0, $email, 0, 2, 'L', false);
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Ln(5);

    // Course Information
    $stmt = $db->prepare('SELECT * FROM courses WHERE courseID = :course_id');
    $status = $stmt->execute(['course_id' => $alumniCourseDetails['course_id']]);
    $course = $stmt->fetch(\PDO::FETCH_ASSOC);
    $course = $course['courseName'];

    $pdf->SetFont('Courier', 'B', 11);
    $pdf->Cell(20, 0, "Program: ", 0, 0, 'L', false);
    $pdf->SetFont('Courier', '', 11);
    $pdf->Cell($cellWidth, 0, $course, 0, 2, 'L', false);
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Ln(5);


    $stmt = $db->prepare('SELECT * FROM coursesmajor WHERE major_id = :major_id');
    $status = $stmt->execute(['major_id' => $alumniCourseDetails['major_id']]);
    $major = $stmt->fetch(\PDO::FETCH_ASSOC);
    bdump($major);
    $major = $major['majorName'];

    if ($major) {
      $pdf->SetFont('Courier', 'B', 11);
      $pdf->Cell(20, 0, "Major: ", 0, 0, 'L', false);
      $pdf->SetFont('Courier', '', 11);
      $pdf->Cell($cellWidth, 0, $major, 0, 2, 'L', false);
      $pdf->SetFont('Courier', 'B', 16);
      $pdf->Ln(5);
    }

    $stmt = $db->prepare('SELECT * FROM campuses WHERE campusID = :campus');
    $status = $stmt->execute(['campus' => $alumniCourseDetails['campus']]);
    $campus = $stmt->fetch(\PDO::FETCH_ASSOC);
    $campus = $campus['campusName'];

    $pdf->SetFont('Courier', 'B', 11);
    $pdf->Cell(20, 0, "Campus: ", 0, 0, 'L', false);
    $pdf->SetFont('Courier', '', 11);
    $pdf->Cell($cellWidth, 0, $campus, 0, 2, 'L', false);
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Ln(5);

    $yearStarted = $alumniCourseDetails['year_started'];
    $yearGraduated = $alumniCourseDetails['year_graduated'];
    $yearDuration = $yearStarted . ' - ' . $yearGraduated;

    $pdf->SetFont('Courier', 'B', 11);
    $pdf->Cell(20, 0, "Year: ", 0, 0, 'L', false);
    $pdf->SetFont('Courier', '', 11);
    $pdf->Cell($cellWidth, 0, $yearDuration, 0, 2, 'L', false);
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Ln(5);


    if ($alumniWorkIDs != '') {
      $pdf->Cell($cellWidth, 0, 'Work Experience', 0, 2, 'C', false);
      $lineY = $pdf->GetY() + 5;
      $pdf->Line($leftMargin, $lineY, $pageWidth - $rightMargin, $lineY);
      $pdf->Ln(10);
      foreach ($alumniWorkExperience as $alumniExperienceInstance) {
        if (in_array($alumniExperienceInstance['work_exp_id'], $alumniWorkIDs)) {
          $pdf->SetFont('Courier', 'B', 11);
          $pdf->Cell(25, 0, "Position: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, $alumniExperienceInstance['work_position'], 0, 2, 'L', false);
          $pdf->Ln(5);

          $pdf->SetFont('Courier', '', 11);
          $pdf->Cell(25, 0, "Company: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, $alumniExperienceInstance['work_name'], 0, 2, 'L', false);
          $pdf->Ln(5);

          $pdf->SetFont('Courier', '', 11);
          $pdf->Cell(25, 0, "Duration: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, (date("F j, Y", strtotime($alumniExperienceInstance['date_started'])) . ' - ' . (date("F j, Y", strtotime($alumniExperienceInstance['date_end'])))), 0, 2, 'L', false);
          $pdf->Ln(2);

          $pdf->SetFont('Courier', '', 11);
          $pdf->MultiCell(0, 5, "Description: " . $alumniExperienceInstance['work_description'], 0, 'L', false);
          $pdf->Ln(5);
        }
      }
    }


    if ($alumniAwardIDs != '') {
      $pdf->SetFont('Courier', 'B', 16);
      $pdf->Cell($cellWidth, 0, 'Awards', 0, 2, 'C', false);
      $lineY = $pdf->GetY() + 5;
      $pdf->Line($leftMargin, $lineY, $pageWidth - $rightMargin, $lineY);
      $pdf->Ln(10);
      foreach ($alumniAwards as $alumniAwardsInstance) {
        if (in_array($alumniAwardsInstance['award_id'], $alumniAwardIDs)) {
          $pdf->SetFont('Courier', 'B', 11);
          $pdf->Cell(25, 0, "Award: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, $alumniAwardsInstance['award_name'], 0, 2, 'L', false);
          $pdf->Ln(5);

          $pdf->SetFont('Courier', '', 11);
          $pdf->Cell(25, 0, "Given By: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, $alumniAwardsInstance['given_by'], 0, 2, 'L', false);
          $pdf->Ln(5);

          $pdf->SetFont('Courier', '', 11);
          $pdf->Cell(25, 0, "Date: ", 0, 0, 'L', false);
          $pdf->Cell($cellWidth, 0, (date("F j, Y", strtotime($alumniAwardsInstance['award_date']))), 0, 2, 'L', false);
          $pdf->Ln(2);

          $pdf->SetFont('Courier', '', 11);
          $pdf->MultiCell(0, 5, "Description: " . $alumniAwardsInstance['award_description'], 0, 'L', false);
          $pdf->Ln(5);
        }
      }
    }

    // Output the PDF
    $pdf->Output();
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
