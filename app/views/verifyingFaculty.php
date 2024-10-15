<?php


function cleanAlphaNumString($string)
{
  return preg_replace("/[^a-zA-Z0-9]/", "", $string);
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
  </div>

  <!-- Faculty Modal -->
  <div class="modal fade p-0" id="verifyingFacultyModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <img src="<?= Flight::request()->base ?>/assets/img/job_programmer.png" width="50px">
          <h1 class="modal-title fs-5 text-primary fw-bold ms-3" id="exampleModalLabel">User Settings</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="verifyingFacultySave" class="row">
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultyEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="facultyEmail" name="facultyEmail" value="<?php echo $facultyData['email_address'] ?>" required>
            </div>
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultyUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="facultyUsername" name="facultyUsername" value="<?php echo $facultyData['username'] ?>" required>
            </div>
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultyFName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="facultyFName" name="facultyFName" value="<?php echo $facultyData['first_name'] ?>" placeholder="Mark" required>
            </div>
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultyMName" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="facultyMName" name="facultyMName" value="<?php echo $facultyData['middle_name'] ?>" placeholder="Santos">
            </div>
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultyLName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="facultyLName" name="facultyLName" value="<?php echo $facultyData['last_name'] ?>" placeholder="Santos" required>
            </div>
            <div class="col-md-4 col-sm-12" id="">
              <label for="facultySuffix" class="form-label">Suffix</label>
              <input type="text" class="form-control" id="facultySuffix" name="facultySuffix" value="<?php echo $facultyData['suffix'] ?>" placeholder="">
            </div>
            <hr>
            <div class="col-md-10 m-2">
              <?= $locations ?>
            </div>
            <hr>
            <div class="col-12">
              <label for="facultyStAdd" class="form-label">Street Address</label>
              <input type="text" class="form-control" id="facultyStAdd" name="facultyStAdd" value="<?php echo $facultyData['street_add'] ?>">
            </div>
            <div class="col-md-6 col-sm-12" id="">
              <label for="facultyCPNumber" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="facultyCPNumber" name="facultyCPNumber" placeholder="" value="<?php echo $facultyData['contact_number'] ?>" maxlength="11" required>
            </div>
            <div class="col-md-6 col-sm-12" id="">
              <label for="facultyBDate" class="form-label">Birth Date</label>
              <input class="form-control" type="date" id="facultyBDate" name="facultyBDate" value="<?php echo $facultyData['birth_date'] ?>" required />
            </div>
            <div class="col-md-4 col-sm-12">
              <label for="facultyCampus" class="form-label">Campus</label>
              <select class="form-select" id="facultyCampus" name="facultyCampus">
                <?php
                foreach ($campuses as $campus) {
                ?>

                  <option <?php
                          if ($campus['campusID'] == $facultyData['campus_id']) {
                            echo "selected ";
                          }
                          ?> value="<?php echo $campus['campusID'] ?>"><?php echo $campus['campusName'] ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-4" id="">
              <label for="facultyID" class="form-label">Faculty ID</label>
              <input type="text" class="form-control" id="facultyID" name="facultyID" value="<?php echo $facultyData['employee_num'] ?>">
            </div>
            <div class="col-4" id="">
              <label for="facultyRank" class="form-label">Academic Rank</label>
              <select type="text" class="form-control" id="facultyRank" name="facultyRank">
                <?php
                foreach ($acadRanks as $acadRank) {
                ?>

                  <option <?php
                          if ($acadRank['faculty_rank_id'] == $facultyData['acadrank_id']) {
                            echo "selected ";
                          }
                          ?> value="<?php echo $acadRank['faculty_rank_id'] ?>"><?php echo $acadRank['f_rank_description'] ?></option>
                <?php
                }
                ?>
              </select>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

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
          if (courseOptionsSpec[x] == "<?php echo  array_search($alumniData[0]["major_id"], $mapMajors) ?>") {
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
