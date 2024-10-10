<?php

if (isset($_POST['applyButton'])) {
  $_SESSION['applyId'] = $_POST['applyButton'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submitApp'])) {
    $test = "hello";
    // Directory where you want to save the uploaded files
    $targetDirectory = "../files/";

    $uniqueID = uniqid(); // Generates a unique ID based on the current time in microseconds
    $targetFile = $targetDirectory . $uniqueID . "_" . basename($_FILES["formFile"]["name"]);


    // Flag to check if everything is okay
    $uploadOk = 1;

    // Get file extension
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file already exists
    if (file_exists($targetFile)) {
      //echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size (limit set to 5MB)
    /* if ($_FILES["fileUpload"]["size"] > 5000000) { */
    /*   echo "Sorry, your file is too large."; */
    /*   $uploadOk = 0; */
    /* } */
    /**/

    // Allow certain file formats (e.g., jpg, png, gif, pdf)
    $allowedFileTypes = array("pdf");
    if (!in_array($fileType, $allowedFileTypes)) {
      //echo "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed." . $fileType;
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      //echo "Sorry, your file was not uploaded." . $targetFile;
    } else {
      // Attempt to move the uploaded file to the target directory
      if (move_uploaded_file($_FILES["formFile"]["tmp_name"], $targetFile)) {
        //echo "The file " . htmlspecialchars(basename($_FILES["formFile"]["name"])) . " has been uploaded.";

        $func->insert('applications', array(
          'file_name' => $targetFile,
          'application_post_id' => $_POST['submitApp'],
          'application_alumni_id' => $_SESSION['userid'],
        ));

        $func->insert('alumni_employment_status', array(
          'status_post_id' => $_POST['submitApp'],
          'status_alumni_id' => $_SESSION['userid'],
          'status' => 0,
        ));
      } else {
        //echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}

$dataInstance = $func->selectjoin3_where('employer_job_posts', 'employer_users', 'companies', 'author_id', 'user_id', 'company_id', 'id', 'employer_job_posts', array('post_id', '=', $_SESSION['applyId']));

$locationArr = array();
$regionInformation = array();
$regionInformation['01'] = 'Region I';
$regionInformation['02'] = 'Region II';
$regionInformation['03'] = 'Region III';
$regionInformation['4A'] = 'Region IV-A';
$regionInformation['4B'] = 'Region IV-B';
$regionInformation['05'] = 'Region V';
$regionInformation['06'] = 'Region VI';
$regionInformation['07'] = 'Region VII';
$regionInformation['08'] = 'Region VIII';
$regionInformation['09'] = 'Region XI';
$regionInformation['10'] = 'Region X';
$regionInformation['11'] = 'Region XI';
$regionInformation['12'] = 'Region XII';
$regionInformation['13'] = 'Region XIII';
$regionInformation['BARMM'] = 'BARMM';
$regionInformation['CAR'] = 'CAR';
$regionInformation['NCR'] = 'NCR';

if ($dataInstance[0]['job_region']) {
  array_push($locationArr, $regionInformation[$dataInstance[0]['job_region']]);
}
if ($dataInstance[0]['job_province']) {
  array_push($locationArr, $dataInstance[0]['job_province']);
}
if ($dataInstance[0]['job_municipality']) {
  array_push($locationArr, $dataInstance[0]['job_municipality']);
}
if ($dataInstance[0]['job_barangay']) {
  array_push($locationArr, $dataInstance[0]['job_barangay']);
}

if (sizeof($locationArr) > 0) {
  $location = implode(', ', $locationArr);
}

if ($dataInstance[0]['job_type'] == '000000') {
  $jobType = false;
} else {
  $jobType = true;
  $jobTypeArray = array();

  if ($dataInstance[0]['job_type'][0] == '1') {
    array_push($jobTypeArray, "Full-Time");
  }
  if ($dataInstance[0]['job_type'][1] == '1') {
    array_push($jobTypeArray, "Part-Time");
  }
  if ($dataInstance[0]['job_type'][2] == '1') {
    array_push($jobTypeArray, "Contract");
  }
  if ($dataInstance[0]['job_type'][3] == '1') {
    array_push($jobTypeArray, "Temporary");
  }
  if ($dataInstance[0]['job_type'][4] == '1') {
    array_push($jobTypeArray, "Remote");
  }
  if ($dataInstance[0]['job_type'][5] == '1') {
    array_push($jobTypeArray, "Freelance");
  }
}


?>

<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CICT CHARM</title>


  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="../../img/favicon.ico">
  <link rel="stylesheet" href="../../css/theme_1/core/libs.min.css">
  <link rel="stylesheet" href="../../css/theme_1/hope-ui.min.css">
  <link rel="stylesheet" href="../../css/theme_1/custom.css">
  <link rel="stylesheet" href="../../css/theme_1/dark.css">
  <link rel="stylesheet" href="../../css/theme_1/rtl.min.css">
  <link rel="stylesheet" href="../../css/theme_1/customizer.min.css">

  <style>
    .jobListItem {
      cursor: pointer;
    }
  </style>

</head>

<body class="  ">
  <!-- loader Start -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>
  <!-- loader END -->
  <!-- Sidebar Menu Start -->
  <?php include 'alumniSidebar.php' ?>
  </div>
  </div>
  <!-- Sidebar Menu End -->
  </aside>
  <main class="main-content">
    <div class="position-relative iq-banner">
      <!--Nav Start-->
      <?php include 'header.php' ?>
      <!-- Nav Header Component Start -->
      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                  <h1>Job Vacancies</h1>
                </div>
                <div>
                  <a href="announcements.php" class="btn btn-link btn-soft-light">
                    <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z" fill="currentColor"></path>
                      <path opacity="0.4" d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z" fill="currentColor"></path>
                    </svg>
                    Announcements
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="iq-header-img">
          <img src="../../img/dashboard/top-header.png" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
      </div>
      <!-- Nav Header Component End -->
    </div>
    <div class="container-fluid content-inner mt-n5 py-0">
      <div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body px-0 m-0 px-5">
                <div class="container w-100">
                  <button type="button" class="btn btn-secondary" onclick="goBack()">Back</button>
                  <hr>
                  <?php
                  ?>
                  <h1><?php echo  $dataInstance[0]['position'] ?></h1>
                  <h4><?php echo  $dataInstance[0]['name'] ?></h4>
                  <p>Slots: <?php echo $dataInstance[0]['slot_available'] ?> </p>
                  <hr class="border border-dark border-1">
                  <?php if ($location) { ?>
                    <div class="d-flex align-items-center">
                      <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                        <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                      </svg>
                      <h4>Location</h4>
                    </div>
                    <div class="d-flex align-items-center">
                      <h6 class="ms-2 bg-light p-1 rounded"> <?php echo $location ?></h6>
                    </div>
                    <hr>
                  <?php
                  }
                  ?>
                  <div class="d-flex align-items-center">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                      <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                    </svg>
                    <h4>Job Type</h4>
                  </div>
                  <div class="d-flex align-items-center">
                    <?php
                    foreach ($jobTypeArray as $jobTypeInstance) {
                    ?>
                      <h6 class="ms-2 bg-light p-1 rounded"> <?php echo $jobTypeInstance ?></h6>
                    <?php
                    }
                    ?>
                  </div>
                  <hr>
                  <div class="d-flex align-items-center">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                      <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                      <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z" />
                    </svg>
                    <h4>Salary</h4>
                  </div>
                  <div class="d-flex align-items-center">
                    <?php
                    if ($dataInstance[0]['salary_format'] == 'hour') {
                    ?>
                      <h6 class="ms-2 bg-light p-1 rounded">Php <?php echo ($dataInstance[0]['salary_hour']) ?>/hr</h6>
                    <?php
                    } else if ($dataInstance[0]['salary_format'] == 'range') {
                    ?>
                      <h6 class="ms-2 bg-light p-1 rounded">Php <?php echo ($dataInstance[0]['salary_min']) ?> - Php <?php echo ($dataInstance[0]['salary_max']) ?></h6>
                    <?php
                    } else {
                    ?>
                      <h6 class="ms-2 bg-light p-1 rounded">Php <?php echo ($dataInstance[0]['salary_format']) ?>/hr</h6>
                    <?php
                    }
                    ?>
                  </div>
                  <hr>
                  <div class="d-flex align-items-center">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                      <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg>
                    <h4>Shift and Schedule</h4>
                  </div>
                  <div class="d-flex align-items-center">
                    <?php
                    switch ($dataInstance[0]['job_shift']) {
                      case '1': {
                          $schedule = "Morning Shift";
                          break;
                        }
                      case '2': {
                          $schedule = "Evening Shift";
                          break;
                        }
                      case '3': {
                          $schedule = "Night Shift";
                          break;
                        }
                      case '4': {
                          $schedule = "Rotating Shift";
                          break;
                        }
                      case '5': {
                          $schedule = "Flexible Shift";
                          break;
                        }
                    }
                    ?>
                    <h6 class="ms-2 bg-light p-1 rounded"><?php echo  $schedule ?></h6>
                  </div>
                  <hr>
                  <p class="text-dark"><?php echo $dataInstance[0]['job_description']; ?></p>
                  <hr class="border border-1">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal" <?php echo $_SESSION['rolename'] == 'Alumni' ? '' : 'disabled' ?>>
                    Apply
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Application</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <h6>Include in your Resume | <?php echo $applyCompany ?></h6>
                          <ul>
                            <li>Educational qualifications</li>
                            <li>Technical Skills</li>
                            <li>Work Experience</li>
                            <li>Soft Skills</li>
                          </ul>
                          <form method="POST" enctype="multipart/form-data">
                            <label for=" formFile" class="form-label">Resume</label>
                            <input class="form-control" type="file" id="resumeFile" name="formFile" accept=".pdf">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" id="submitApp" name="submitApp" value="<?php echo $dataInstance[0]['post_id'] ?>" disabled>Submit Application</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <p><?php echo  $applyHistory ?></p>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body px-0 m-0">
                <div class="container">
                  <h1>Comments</h1>
                  <div class="container">
                    <form>
                      <div class="input-group">
                        <span class="input-group-text">Add a comment</span>
                        <textarea class="form-control" aria-label="With textarea" id="commentTextArea"></textarea>
                      </div>
                      <div class="my-2 text-center">
                        <button class="btn btn-secondary" type="button" id="commentButton" disabled>Comment</button>
                      </div>
                    </form>
                  </div>
                  <div class="card bg-body-tertiary">
                    <div class="card-body">
                      <div class="container">
                        <img src="" class="border border-0 bg-light" width="100px" height="100px">
                        <p>Demo Name
                        <p>
                        <p class="fs-4 text-dark">This a comment</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script>
              function showDeleteAlert() {
                Swal.fire({
                  title: 'Deleted!',
                  text: 'The job is successfully deleted.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              }

              function showEditAlert() {
                Swal.fire({
                  title: 'Edited!',
                  text: 'The job is successfully edited.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                });
              }

              function goBack() {
                window.history.back();
              }
            </script>

            <script src="../../js/core/libs.min.js"></script>
            <script src="../../js/core/external.min.js"></script>
            <script src="../../js/charts/widgetcharts.js"></script>
            <script src="../../js/charts/vectore-chart.js"></script>
            <script src="../../js/charts/dashboard.js"></script>
            <script src="../../js/plugins/fslightbox.js"></script>
            <script src="../../js/plugins/setting.js"></script>
            <script src="../../js/plugins/slider-tabs.js"></script>
            <script src="../../js/plugins/form-wizard.js"></script>
            <script src="../../js/hope-ui.js" defer></script>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
            <script>
              function isBlank(str) {
                return str.trim().length === 0;
              }

              const cmntTA = document.getElementById("commentTextArea");
              const cmntBtn = document.getElementById("commentButton");
              const resFile = document.getElementById("resumeFile");
              const subApp = document.getElementById("submitApp");

              cmntTA.addEventListener('input', function() {
                console.log("hello");
                if (isBlank(cmntTA.value)) {
                  cmntBtn.disabled = true;
                } else {
                  cmntBtn.disabled = false;
                }
              });

              resFile.addEventListener('change', function() {
                if (resFile.files.lengt == 0) {
                  subApp.disabled = true;
                } else {
                  subApp.disabled = false;
                }
              })
            </script>
</body>

</html>
