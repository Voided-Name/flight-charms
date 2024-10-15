<?php

function cleanAlphaNumString($string)
{
  return preg_replace("/[^a-zA-Z0-9]/", "", $string);
}


if (isset($_POST['saveBtn'])) {
  /**
   * 
   * @var strip $strip
   */
  /**
   * 
   * @var res $func
   */

  if ($_SESSION['role'] == 1) {
    $email = $strip->strip($_POST['alumniEmail']);
    $username = $strip->strip($_POST['alumniUsername']);
    $firstName = $strip->strip($_POST['alumniFName']);
    $middleName = $strip->strip($_POST['alumniMName']);
    $lastName = $strip->strip($_POST['alumniLName']);
    $suffix = $strip->strip($_POST['alumniSuffix']);
    $region = $strip->strip($_POST['alumniRegion']);
    $province = $strip->strip($_POST['alumniProvince']);
    $municipality = $strip->strip($_POST['alumniMunicipality']);
    $barangay = $strip->strip($_POST['alumniBarangay']);
    $streetAdd = $strip->strip($_POST['alumniStAdd']);
    $contactNumber = $strip->strip($_POST['alumniCPNumber']);
    $birthDate = $strip->strip($_POST['alumniBDate']);
    $studentId = $strip->strip($_POST['alumniStudId']);
    $course = $strip->strip($_POST['alumniCourse']);
    $major = $strip->strip($_POST['alumniMajor']);
    $campus = $strip->strip($_POST['alumniCampus']);
    $yearGraduated = $strip->strip($_POST['alumniGraduated']);
    $yearEnrolled = $strip->strip($_POST['alumniEnrolled']);

    $selectUser = $func->select_one('users', array('username', '=', $email));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    } else {
      if ($selectUser) {
        if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
          $debug = $selectUser[0]['id'];
          $debug2 = $_SESSION['userid'];
          $emailErrExists = true;
        }
      } else {
        $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
          'email_address' => $email
        ));
      }
    }

    $selectUser = $func->select_one('users', array('username', '=', $username));

    if ($selectUser) {
      if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
        $usernameErr = true;
      }
    } else {
      $updateDetails2 = $func->update('users', 'id', $_SESSION['userid'], array('username' => $username));
    }

    $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
      'contact_number' => $contactNumber,
      'first_name' => $firstName,
      'middle_name' => $middleName,
      'last_name' => $lastName,
      'birth_date' => $birthDate,
      'region' => $region,
      'province' => $province,
      'city' => $municipality,
      'barangay' => $barangay,
      'street_add' => $streetAdd,
      'suffix' => $suffix
    ));

    $majors = $func->selectall('coursesmajor');
    $mapMajors = array_combine(array_column($majors, 'majorName'), array_column($majors, 'id'));


    $updateDetails3 = $func->update('alumni_graduated_course', 'user_id', $_SESSION['userid'], array(
      'course_id' => $course,
      'campus' => $campus,
      'alumniNum' => $studentId,
      'major_id' => $mapMajors[$major],
      'year_started' => $yearEnrolled,
      'year_graduated' => $yearGraduated
    ));

    if (!$updateDetails3) {
      $alumni_grad_table_exist = $func->selectall_where('alumni_graduated_course', array('user_id', '=', $_SESSION['userid']));

      if (!$alumni_grad_table_exist) {
        $insertDetails = $func->insert('alumni_graduated_course', array(
          'user_id' => $_SESSION['userid'],
          'course_id' => $course,
          'campus' => $campus,
          'alumniNum' => $studentId,
          'major_id' => $mapMajors[$major],
          'year_started' => $yearEnrolled,
          'year_graduated' => $yearGraduated
        ));
      }
    }
  } else if ($_SESSION['role'] == 2) {
    $email = $strip->strip($_POST['employerEmail']);
    $username = $strip->strip($_POST['employerUsername']);
    $firstName = $strip->strip($_POST['employerFName']);
    $middleName = $strip->strip($_POST['employerMName']);
    $lastName = $strip->strip($_POST['employerLName']);
    $suffix = $strip->strip($_POST['employerSuffix']);
    $region = $strip->strip($_POST['employerRegion']);
    $province = $strip->strip($_POST['employerProvince']);
    $municipality = $strip->strip($_POST['employerMunicipality']);
    $barangay = $strip->strip($_POST['employerBarangay']);
    $streetAdd = $strip->strip($_POST['employerStAdd']);
    $contactNumber = $strip->strip($_POST['employerCPNumber']);
    $birthDate = $strip->strip($_POST['employerBDate']);
    $companyName = $strip->strip($_POST['employerCompany']);

    if ($companyName == "0") {
      $companyName2 = $strip->strip($_POST['employerCompanySTR']);
    }

    $position = $strip->strip($_POST['employerPosition']);

    $selectUser = $func->select_one('users', array('username', '=', $email));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailInvalid = true;
    } else {
      if ($selectUser) {
        if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
          $emailErrExists = true;
        }
      } else {
        $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
          'email_address' => $email
        ));
      }
    }

    $selectUser = $func->select_one('users', array('username', '=', $username));

    if ($selectUser) {
      if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
        $usernameErr = true;
      }
    } else {
      $updateDetails2 = $func->update('users', 'id', $_SESSION['userid'], array('username' => $username));
    }

    $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
      'contact_number' => $contactNumber,
      'first_name' => $firstName,
      'middle_name' => $middleName,
      'last_name' => $lastName,
      'birth_date' => $birthDate,
      'region' => $region,
      'province' => $province,
      'city' => $municipality,
      'barangay' => $barangay,
      'street_add' => $streetAdd,
      'suffix' => $suffix
    ));

    if ($companyName2) {
      $updateDetails3 = $func->update('employer_users', 'user_id', $_SESSION['userid'], array(
        'company_unvalidated' => $companyName2,
        'company_id' => 0,
        'company_position' => $position,
      ));

      if (!$updateDetails3) {
        $employer_users_exists = $func->selectall_where('employer_users', array('user_id', '=', $_SESSION['userid']));

        if (!$employer_users_exists) {
          $insertDetails = $func->insert('employer_users', array(
            'user_id' => $_SESSION['userid'],
            'company_unvalidated' => $companyName2,
            'company_id' => 0,
            'company_position' => $position,
          ));
        }
      }
    } else {
      $updateDetails3 = $func->update('employer_users', 'user_id', $_SESSION['userid'], array(
        'company_id' => $companyName,
        'company_position' => $position,
      ));

      if (!$updateDetails3) {
        $employer_users_exists = $func->selectall_where('employer_users', array('user_id', '=', $_SESSION['userid']));

        if (!$employer_users_exists) {
          $insertDetails = $func->insert('employer_users', array(
            'user_id' => $_SESSION['userid'],
            'company_id' => $companyName,
            'company_position' => $position,
          ));
        }
      }
    }
  } else if ($_SESSION['role'] == 3) {
    $email = $strip->strip($_POST['facultyEmail']);
    $username = $strip->strip($_POST['facultyUsername']);
    $firstName = $strip->strip($_POST['facultyFName']);
    $middleName = $strip->strip($_POST['facultyMName']);
    $lastName = $strip->strip($_POST['facultyLName']);
    $suffix = $strip->strip($_POST['facultySuffix']);
    $region = $strip->strip($_POST['facultyRegion']);
    $province = $strip->strip($_POST['facultyProvince']);
    $municipality = $strip->strip($_POST['facultyMunicipality']);
    $barangay = $strip->strip($_POST['facultyBarangay']);
    $streetAdd = $strip->strip($_POST['facultyStAdd']);
    $contactNumber = $strip->strip($_POST['facultyCPNumber']);
    $birthDate = $strip->strip($_POST['facultyBDate']);
    $campus = $strip->strip($_POST['facultyCampus']);
    $facultyID = $strip->strip($_POST['facultyID']);
    $acadRank = $strip->strip($_POST['facultyRank']);


    $selectUser = $func->select_one('users', array('username', '=', $email));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailInvalid = true;
    } else {
      if ($selectUser) {
        if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
          $emailErrExists = true;
        }
      } else {
        $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
          'email_address' => $email
        ));
      }
    }

    $selectUser = $func->select_one('users', array('username', '=', $username));

    if ($selectUser) {
      if (!($selectUser[0]['id'] == $_SESSION['userid'])) {
        $usernameErr = true;
      }
    } else {
      $updateDetails2 = $func->update('users', 'id', $_SESSION['userid'], array('username' => $username));
    }


    $updateDetails1 = $func->update('userdetails', 'user_id', $_SESSION['userid'], array(
      'contact_number' => $contactNumber,
      'first_name' => $firstName,
      'middle_name' => $middleName,
      'last_name' => $lastName,
      'birth_date' => $birthDate,
      'region' => $region,
      'province' => $province,
      'city' => $municipality,
      'barangay' => $barangay,
      'street_add' => $streetAdd,
      'suffix' => $suffix
    ));

    $updateDetails3 = $func->update('faculty', 'user_id', $_SESSION['userid'], array(
      'campus_id' => $campus,
      'acadrank_id' => $acadRank,
      'employee_num' => $facultyID
    ));

    if (!$updateDetails3) {
      $faculty_exists = $func->selectall_where('faculty', array('user_id', '=', $_SESSION['userid']));

      if (!$faculty_exists) {
        $insertDetails = $func->insert('faculty', array(
          'user_id' => $_SESSION['userid'],
          'campus_id' => $campus,
          'acadrank_id' => $acadRank,
          'employee_num' => $facultyID
        ));
      }
    }
  }
}

?>
<!doctype html>

<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CHARMS</title>
  <link href="<?= Flight::request()->base ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?= Flight::request()->base ?>/assets/css/theme_0/animate.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    html,
    body {
      height: 100%;
    }

    body {
      background-image: url("<?= Flight::request()->base ?>/assets/img/floorplan.jpg");
      background-size: cover;
    }

    #main-content {
      display: none;
    }

    .maintenance {
      max-height: 300px;
    }
  </style>
  <script src="https://unpkg.com/htmx.org@2.0.3"></script>
</head>

<body class="d-flex row align-items-center justify-content-center">
  <div class="text-center" id="loading-screen">
    <div class="spinner-grow" style="width: 40%; padding-top: 40%;" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div id="main-content">
    <div class="container-fluid d-flex flex-column bg-dark shadow p-3" style="--bs-bg-opacity: 70%">
      <div class="container ">
        <img src="<?= Flight::request()->base ?>/assets/img/verifying.png" class="rounded mx-auto d-block maintenance col" alt="Verifiying Account">
      </div>
      <h1 class="text-light m-auto fw-bold">Verification Pending</h1>
      <button type="button" class="btn btn-primary m-auto my-3" data-bs-toggle="modal" data-bs-target="#verifying<?php
                                                                                                                  if ($_SESSION['role'] == 1) {
                                                                                                                    echo "Alumni";
                                                                                                                  } else if ($_SESSION['role'] == 2) {
                                                                                                                    echo "Employer";
                                                                                                                  } else if ($_SESSION['role'] == 3) {
                                                                                                                    echo "Faculty";
                                                                                                                  }
                                                                                                                  ?>Modal">Complete User Profile</button>
      <div id="errDiv"></div>
    </div>
    <button>Back</button>
  </div>

  <!-- Alumni Modal -->
  <?php
  if ($_SESSION['role'] == 1) {
  ?>
    <div class="modal fade p-0" id="verifyingAlumniModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <img src="<?= Flight::request()->base ?>/assets/img/job_programmer.png" width="50px">
            <h1 class="modal-title fs-5 text-primary fw-bold ms-3" id="exampleModalLabel">User Settings</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="verifyingAlumniSave" class="row">
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="alumniEmail" name="alumniEmail" value="<?php echo $alumniData['email_address'] ?>" required>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="alumniUsername" name="alumniUsername" value="<?php echo $alumniData['username'] ?>" required>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniFName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="alumniFName" name="alumniFName" value="<?php echo $alumniData['first_name'] ?>" placeholder="Mark" required>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniMName" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="alumniMName" name="alumniMName" value="<?php echo $alumniData['middle_name'] ?>" placeholder="Santos">
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniLName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="alumniLName" name="alumniLName" value="<?php echo $alumniData['last_name'] ?>" placeholder="Santos" required>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniSuffix" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="alumniSuffix" name="alumniSuffix" value="<?php echo $alumniData['suffix'] ?>" placeholder="">
              </div>
              <hr>
              <div class="col-md-10 m-2">
                <?= $locations ?>
              </div>
              <hr>
              <div class="col-12">
                <label for="alumniStAdd" class="form-label">Street Address</label>
                <input type="text" class="form-control" id="alumniStAdd" name="alumniStAdd" value="<?php echo $alumniData['street_add'] ?>">
              </div>
              <div class="col-md-6 col-sm-12" id="">
                <label for="alumniCPNumber" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="alumniCPNumber" name="alumniCPNumber" placeholder="" value="<?php echo $alumniData['contact_number'] ?>" maxlength="11" required>
              </div>
              <div class="col-md-6 col-sm-12" id="">
                <label for="alumniBDate" class="form-label">Birth Date</label>
                <input class="form-control" type="date" id="alumniBDate" name="alumniBDate" value="<?php echo $alumniData['birth_date'] ?>" required />
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniStudId" class="form-label">Alumni ID</label>
                <input type="text" class="form-control" id="alumniStudId" name="alumniStudId" value="<?php echo $alumniData['studnum'] ?>" required>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniCourse" class="form-label">Course</label>
                <select class="form-select" id="alumniCourse" name="alumniCourse">
                  <?php
                  foreach ($courses as $course) {
                  ?>
                    <option <?php if ($course['courseID'] == $alumniData['course_id']) {
                              echo "selected ";
                            } ?>value="<?php echo $course['courseID'] ?>"><?php echo $course['courseName'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 col-sm-12" id="">
                <label for="alumniMajor" class="form-label">Major</label>
                <select class="form-select" id="alumniMajor" name="alumniMajor">
                  <option value="N/A">N/A</option>
                </select>
              </div>
              <div class="col-md-4 col-sm-12">
                <label for="alumniCampus" class="form-label">Campus</label>
                <select class="form-select" id="alumniCampus" name="alumniCampus">
                  <?php
                  foreach ($campuses as $campus) {
                  ?>

                    <option <?php
                            if ($campus['campusID'] == $alumniData['campus']) {
                              echo "selected ";
                            }
                            ?> value="<?php echo $campus['campusID'] ?>"><?php echo $campus['campusName'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4 col-sm-12">
                <label for="alumniGraduated" class="form-label">Year Graduated</label>
                <input type="number" class="form-control" id="alumniGraduated" name="alumniGraduated" value=<?php echo $alumniData['year_graduated'] ?> aria-describedby="" required>
              </div>
              <div class="col-md-4 col-sm-12">
                <label for="alumniEnrolled" class="form-label">Year Enrolled (Initially)</label>
                <input type="number" class="form-control" id="alumniEnrolled" name="alumniEnrolled" value=<?php echo $alumniData['year_started'] ?> aria-describedby="" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="saveBtn">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    let userRole = "<?php
                    switch ($_SESSION['role']) {
                      case "1":
                        echo "alumni";
                        break;
                      case "2":
                        echo "employer";
                        break;
                      case "3":
                        echo "faculty";
                        break;
                    }
                    ?>";

    function removeOptions(selectElement) {
      var i, L = selectElement.options.length - 1;
      for (i = L; i >= 0; i--) {
        selectElement.remove(i);
      }
    }

    <?php if ($_SESSION['role'] == 1) { ?>
      const courseOptions = document.getElementById('alumniCourse');
      courseOptions.addEventListener("change", alumniMajorOptions);


      const BSElemEduc = ["N/A"];
      const BSIndusTech = [
        "Apparel and Fashion Technology",
        "Automotive Technology",
        "Drafting Technology",
        "Electrical Technology",
        "Electronics Technology",
        "Food Technology",
        "Heating, Ventilating and Air-Conditioning Technology",
        "Mechanical Technology"
      ];;

      const BPhyEduc = ["N/A"];
      const BPubAd = ["N/A"];
      const BSAgri = ["Animal Science", "Crop Science", "Agricultural Extension", "Agro-forestry", ];
      const BSArchi = ["N/A"];
      const BSBio = ["N/A"];
      const BSBA = ["Financial Management", "Human Resource Development Management", "Marketing Management"];
      const BSChem = ["N/A"];
      const BSCivilEng = ["N/A"];
      const BSCrim = ["N/A"];
      const BSElecEng = ["N/A"];
      const BSEnSci = ["N/A"];
      const BSFoodTech = ["N/A"];
      const BSHM = ["N/A"];
      const BSHRM = ["N/A"];
      const BSInEduc = ["N/A"];
      const BSIT = ["Database Systems Technology", "Network Systems Technology", "Web Systems Technology"];
      const BSMechEng = ["N/A"];
      const BSNursing = ["N/A"];
      const BSPhyEduc = ["N/A"];
      const BSPsych = ["N/A"];
      const BSTM = ["N/A"];
      const BSEduc = ["Science Education", "Mathematics Education", "Physics Education", "English Education", "Filipino Education", "Social Studies Education"];
      const BSNE = ["N/A"];
      const BSEntrep = ["N/A"];
      const BSTLE = ["N/A"];
      const ECET = ["N/A"];


      const mapCourseToMajors = new Map();
      mapCourseToMajors.set('1', BSElemEduc);
      mapCourseToMajors.set('2', BSIndusTech);
      mapCourseToMajors.set('3', BPhyEduc);
      mapCourseToMajors.set('4', BPubAd);
      mapCourseToMajors.set('5', BSAgri);
      mapCourseToMajors.set('6', BSArchi);
      mapCourseToMajors.set('7', BSBio);
      mapCourseToMajors.set('8', BSBA);
      mapCourseToMajors.set('9', BSChem);
      mapCourseToMajors.set('10', BSCivilEng);
      mapCourseToMajors.set('11', BSCrim);
      mapCourseToMajors.set('12', BSElecEng);
      mapCourseToMajors.set('13', BSEnSci);
      mapCourseToMajors.set('14', BSFoodTech);
      mapCourseToMajors.set('15', BSHM);
      mapCourseToMajors.set('16', BSHRM);
      mapCourseToMajors.set('17', BSInEduc);
      mapCourseToMajors.set('18', BSIT);
      mapCourseToMajors.set('19', BSMechEng);
      mapCourseToMajors.set('20', BSNursing);
      mapCourseToMajors.set('21', BSPhyEduc);
      mapCourseToMajors.set('22', BSPsych);
      mapCourseToMajors.set('23', BSTM);
      mapCourseToMajors.set('24', BSEduc);
      mapCourseToMajors.set('25', BSNE);
      mapCourseToMajors.set('26', BSEntrep);
      mapCourseToMajors.set('27', BSTLE);
      mapCourseToMajors.set('28', ECET);


      function alumniMajorOptions() {
        const majorOptions = document.getElementById('alumniMajor');
        removeOptions(majorOptions);
        courseOptionsSpec = mapCourseToMajors.get(courseOptions.value);
        for (x = 0; x < courseOptionsSpec.length; x++) {
          let el = document.createElement("option");
          el.textContent = courseOptionsSpec[x];
          if (courseOptionsSpec[x] == "<?php echo  array_search($alumniData["major_id"], $mapMajors) ?>") {
            el.selected = true;
          }
          el.value = courseOptionsSpec[x];
          majorOptions.appendChild(el);
        }
      }

    <?php } else if ($_SESSION['role'] == 2) {
    ?>
      companyNameSel = document.getElementById("employerCompany");
      companyNameSel.addEventListener("change", function() {
        updateCompanyName(false)
      });
    <?php
    } ?>

    function updateCompanyName(isStart) {
      let input1 = document.getElementById("employerCompany");
      if (input1.value == "0") {
        document.getElementById("companySTRdiv").style.display = "block";
        if (!isStart) {
          document.getElementById("companySTRdiv").classList.add("animate__animated");
          document.getElementById("companySTRdiv").classList.add("animate__shakeX");
        }
        document.getElementById("employerCompanyDiv").classList.remove("col-md-6");
        document.getElementById("employerCompanyDiv").classList.add("col-md-2");
        document.getElementById("employerCompanySTR").required = true;
      } else {
        document.getElementById("companySTRdiv").style.display = "none";
        document.getElementById("companySTRdiv").classList.remove("animate__animated");
        document.getElementById("companySTRdiv").classList.remove("animate__shakeX");
        document.getElementById("employerCompanyDiv").classList.add("col-md-6");
        document.getElementById("employerCompanyDiv").classList.remove("col-md-2");
        document.getElementById("employerCompanySTR").required = false;
      }
    }

    function sweetAlertSaveChanges() {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: "Changed Saved!",
        heightAuto: false,
      });
    }


    window.addEventListener('load', function() {
      document.getElementById("loading-screen").style.display = "none";
      document.getElementById("main-content").style.display = "block";
      document.getElementById("main-content").classList.add("animate__animated");
      document.getElementById("main-content").classList.add("animate__zoomIn");
      alumniMajorOptions();
    })

    $(document).ready(function() {
      <?php if ($_SESSION['role'] == 2) { ?>
        updateCompanyName(true);
      <?php
      } ?>
      $('#' + userRole + 'CPNumber').focusout(function() {
        var input = $(this).val();

        // Regular expression to check if input starts with 09 and has exactly 11 digits
        var regex = /^09\d{9}$/;

        if (!regex.test(input)) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'The input must be 11 digits, start with 09, and contain no alphabets or special characters.'
          }).then(() => {
            $('#' + userRole + 'CPNumber').focus();
          });
        }
      });

      $('#' + userRole + 'BDate').focusout(function() {
        var inputDate = new Date($(this).val());
        alert(inputDate);
        var today = new Date();

        // Calculate age
        var age = today.getFullYear() - inputDate.getFullYear();
        var monthDifference = today.getMonth() - inputDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < inputDate.getDate())) {
          age--;
        }

        // Check if age is less than 18
        if (age < 18) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid Age',
            text: 'You must be 18 years or older.'
          }).then(() => {
            $('#inputBDate').focus();
          });
        }
      });

      $.getJSON("locations.json", function(result) {
        $.each(result, function(i, field) {
          $('#' + userRole + 'Region').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
        });
        getProvinces($("#" + userRole + "Region").val());
        getMunicipality($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val());
        getBarangay($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val(), $("#" + userRole + "Municipality").val());
      });

      $("#" + userRole + "Region").change(function() {
        $('#' + userRole + 'Province').empty();
        $('#' + userRole + 'Municipality').empty();
        $('#' + userRole + 'Barangay').empty();
        getProvinces($("#" + userRole + "Region").val());
      });

      function getProvinces(region_name) {
        $.getJSON("locations.json", function(result) {
          $.each(result[region_name].province_list, function(key, value) {
            $('#' + userRole + 'Province').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getMunicipality($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val());
        });
      }

      $("#" + userRole + "Province").change(function() {
        $('#' + userRole + 'Municipality').empty();
        $('#' + userRole + 'Barangay').empty();
        getMunicipality($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val());
      });

      function getMunicipality(region_name, province_name) {
        $.getJSON("locations.json", function(result) {
          // console.log(result[region_name].province_list[province_name]);
          $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
            // console.log(key);
            $('#' + userRole + 'Municipality').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getBarangay($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val(), $("#" + userRole + "Municipality").val());
        });
      }

      $("#" + userRole + "Municipality").change(function() {

        $('#' + userRole + 'Barangay').empty();
        getBarangay($("#" + userRole + "Region").val(), $("#" + userRole + "Province").val(), $("#" + userRole + "Municipality").val());
      });

      function getBarangay(region_name, province_name, municipality_name) {
        $.getJSON("locations.json", function(result) {
          // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
          $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
            // console.log(key);
            $('#' + userRole + 'Barangay').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
          });
        });
      }

    });
    const errPlaceholder = document.getElementById("errDiv");
    const appendAlert = (message, type) => {
      const wrapper = document.createElement('div')
      wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
      ].join('')

      errPlaceholder.append(wrapper)
    }
  </script>
</body>

</html>
