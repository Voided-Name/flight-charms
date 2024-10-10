<?php

bdump($dataInstance);
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

if ($dataInstance['job_region']) {
  array_push($locationArr, $regionInformation[$dataInstance['job_region']]);
}
if ($dataInstance['job_province']) {
  array_push($locationArr, $dataInstance['job_province']);
}
if ($dataInstance['job_municipality']) {
  array_push($locationArr, $dataInstance['job_municipality']);
}
if ($dataInstance['job_barangay']) {
  array_push($locationArr, $dataInstance['job_barangay']);
}

if (sizeof($locationArr) > 0) {
  $location = implode(', ', $locationArr);
}

bdump($dataInstance['job_type']);

if ($dataInstance['job_type'] == '000000') {
  $jobType = false;
} else {
  $jobType = true;
  $jobTypeArray = array();

  if ($dataInstance['job_type'][0] == '1') {
    array_push($jobTypeArray, "Full-Time");
  }
  if ($dataInstance['job_type'][1] == '1') {
    array_push($jobTypeArray, "Part-Time");
  }
  if ($dataInstance['job_type'][2] == '1') {
    array_push($jobTypeArray, "Contract");
  }
  if ($dataInstance['job_type'][3] == '1') {
    array_push($jobTypeArray, "Temporary");
  }
  if ($dataInstance['job_type'][4] == '1') {
    array_push($jobTypeArray, "Remote");
  }
  if ($dataInstance['job_type'][5] == '1') {
    array_push($jobTypeArray, "Freelance");
  }
}


?>
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
              <h1><?php echo  $dataInstance['position'] ?></h1>
              <h4><?php echo  $dataInstance['company_name'] ?></h4>
              <p>Slots: <?php echo $dataInstance['slot_available'] ?> </p>
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
              if (!($dataInstance['job_type'] == '000000')) {
              ?>
                <div class="d-flex align-items-center">
                  <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                  </svg>
                  <h4>Job Type</h4>
                </div>
                <div class="d-flex align-items-center">
                  <?php
                  if ($jobType) {

                    foreach ($jobTypeArray as $jobTypeInstance) {
                  ?>
                      <h6 class="ms-2 bg-light p-1 rounded"> <?php echo $jobTypeInstance ?></h6>
                  <?php
                    }
                  }
                  ?>
                </div>
              <?php } ?>
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
                if ($dataInstance['salary_format'] == 'hour') {
                ?>
                  <h6 class="ms-2 bg-light p-1 rounded">Php <?php echo ($dataInstance['salary_hour']) ?>/hr</h6>
                <?php
                } else if ($dataInstance['salary_format'] == 'range') {
                ?>
                  <h6 class="ms-2 bg-light p-1 rounded">Php <?php echo ($dataInstance['salary_min']) ?> - Php <?php echo ($dataInstance[0]['salary_max']) ?></h6>
                <?php
                } else {
                ?>
                  <h6 class="ms-2 bg-light p-1 rounded"><?php echo (strtoupper($dataInstance['salary_format'])) ?></h6>
                <?php
                }
                ?>
              </div>
              <hr>
              <?php if ($dataInstance['job_shift'] != 0) {
              ?>
                <div class="d-flex align-items-center">
                  <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                  </svg>
                  <h4>Shift and Schedule</h4>
                </div>
                <div class="d-flex align-items-center">
                  <?php
                  switch ($dataInstance['job_shift']) {
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
                  <?php if ($dataInstance['job_shift'] != 0) { ?>
                    <h6 class="ms-2 bg-light p-1 rounded"><?php echo  $schedule ?></h6>
                  <?php } ?>
                </div>
              <?php } ?>
              <hr>
              <p class="text-dark"><?php echo $dataInstance['job_description']; ?></p>
              <hr class="border border-1">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal">
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
                      <h6>Include in your Resume | <?php echo "Hello" ?></h6>
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
                      <button type="submit" class="btn btn-primary" id="submitApp" name="submitApp" value="<?php echo $dataInstance['job_id'] ?>" disabled>Submit Application</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <p><?php //echo  $applyHistory 
                  ?></p>
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
      </div>
    </div>
  </div>
</div>

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
