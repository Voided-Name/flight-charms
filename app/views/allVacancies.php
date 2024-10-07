<?php
$_SESSION['employerPage'] = 'allVacancies';

if (!isset($_GET['page'])) {
  $_SESSION['pagination'] = 1;
  $_SESSION['paginationNum'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === "next") {
      if (isset($_SESSION['paginationNum'])) {
        $_SESSION['paginationNum'] += 1;
      }
    } else if ($page === "previous") {
      if (isset($_SESSION['paginationNum'])) {
        $_SESSION['paginationNum'] -= 1;
        if ($_SESSION['paginationNum'] < 0) {
          $_SESSION['paginationNum'] = 0;
        }
        $_SESSION['pagination'] = 3 * $_SESSION['paginationNum'] + 1;
      }
    } else {
      $_SESSION['pagination'] = (int) $page;
    }
  }
}

if (isset($_POST['applyFilters'])) {
  $filterData = array($_POST['locationCheckboxes'], $_POST['jobTypeCheckboxes'], $_POST['radioShift'], $_POST['radioEducation']);
  $locationFilters = array('', '', '', '');
  $jobTypeFilters = $filterData[1];

  if ($filterData[0]) {
    if (in_array('regionCheckVal', $filterData[0])) {
      $locationFilters[0] = $_POST['regions'];
    }
    if (in_array('provinceCheckVal', $filterData[0])) {
      $locationFilters[1] = $_POST['provinces'];
    }
    if (in_array('municipalityCheckVal', $filterData[0])) {
      $locationFilters[2] = $_POST['municipalities'];
    }
    if (in_array('municipalityCheckVal', $filterData[0])) {
      $locationFilters[3] = $_POST['barangays'];
    }
  }

  $_SESSION['locationFilters'] = $locationFilters;
  $_SESSION['jobTypeFilters'] = $jobTypeFilters;
  $_SESSION['shiftFilter'] = $filterData[2];
  $_SESSION['educFilter'] = $filterData[3];
  header("location: vacancies.php");
}

//$data = $func->vacancy_filters('employer_job_posts', 'employer_users', 'companies', 'author_id', 'user_id', 'company_id', 'id', $_SESSION['paginationNum'] * 5, 6, $_SESSION['locationFilters'], $_SESSION['jobTypeFilters'], $_SESSION['shiftFilter'], $_SESSION['educFilter']);
//$dataCount = $func->vacancy_filters('employer_job_posts', 'employer_users', 'companies', 'author_id', 'user_id', 'company_id', 'id', false, false, $_SESSION['locationFilters'], $_SESSION['jobTypeFilters'], $_SESSION['shiftFilter'], $_SESSION['educFilter']);

if (sizeof($data) == 6) {
  $nextState = true;
}

?>

<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CICT CHARM</title>


  <link rel="shortcut icon" href="../../img/favicon.ico">
  <link rel="stylesheet" href="../../css/theme_1/core/libs.min.css">
  <link rel="stylesheet" href="../../css/theme_1/hope-ui.min.css">
  <link rel="stylesheet" href="../../css/theme_1/custom.css">
  <link rel="stylesheet" href="../../css/theme_1/dark.css">
  <link rel="stylesheet" href="../../css/theme_1/rtl.min.css">
  <link rel="stylesheet" href="../../css/theme_1/customizer.min.css">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
  <?php
  if ($_SESSION['role'] == 1) {
    include 'alumniSidebar.php';
  } else if ($_SESSION['role'] == 2) {
    include 'employerSidebar.php';
  } ?>
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
    <div class="conatiner-fluid content-inner mt-n5 py-0">
      <div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body px-0 m-0">
                <div class="container row m-auto shadow-lg p-5">
                  <div class="col-12 col-lg-3 container">
                    <h3 class="text-primary">Filter Jobs</h3>
                    <div class="container border border-dark-subtle rounded p-3">
                      <form method="POST">
                        <div class="row mb-2">
                          <div class="col-12">
                            <button type="submit" class="btn btn-primary" name="applyFilters">Apply Filters</button>
                          </div>
                          <div class="col-12">
                            <legend>Location of Deployment</legend>
                          </div>
                          <div class="col-12">
                            <ul class="list-group">
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="regionCheckVal" id="regionCheckbox" name="locationCheckboxes[]">
                                <label class="form-check-label" for="regionCheckbox">Region</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="provinceCheckVal" id="provinceCheckbox" name="locationCheckboxes[]">
                                <label class="form-check-label" for="provinceCheckbox">Province</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="municipalityCheckVal" id="municipalityCheckbox" name="locationCheckboxes[]">
                                <label class="form-check-label" for="municipalityCheckbox">Municipality</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="barangayCheckVal" id="barangayCheckbox" name="locationCheckboxes[]">
                                <label class="form-check-label" for="barangayCheckbox">Barangay</label>
                              </li>
                            </ul>
                          </div>
                          <div class="col-12">
                            <select class="form-select " id="regions" disabled style="display:none" name="regions">
                              <option selected="" disabled>Region</option>
                            </select>
                            <select class="form-select " id="provinces" disabled style="display:none" name="provinces">
                              <option selected="" disabled>Province</option>
                            </select>
                            <select class="form-select " id="municipalities" disabled style="display:none" name="municipalities">
                              <option selected="" disabled>Municipality</option>
                            </select>
                            <select class="form-select " id="barangays" disabled style="display:none" name="barangays">
                              <option selected="" disabled>Barangay</option>
                            </select>
                          </div>
                        </div>
                        <hr class="border border-1 border-primary opacity-25">
                        <div class="row mb-2">
                          <div class="col-12">
                            <legend>Job Type</legend>
                          </div>
                          <div class="col-12">
                            <ul class="list-group">
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="fullTime" id="fullTimeBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Full-Time</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="partTime" id="partTimeBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Part-Time</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="contract" id="contractBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Contract</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="temporary" id="temporaryBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Temporary</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="remote" id="remoteBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Remote</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="checkbox" value="freelance" id="freelanceBtn" name="jobTypeCheckboxes[]">
                                <label class="form-check-label" for="">Freelance</label>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <hr class="border border-1 border-primary opacity-25">
                        <div class="row mb-2">
                          <div class="col-12">
                            <legend>Shift</legend>
                          </div>
                          <div class="col-12">
                            <ul class="list-group">
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="0" id="noneRadio" checked>
                                <label class="form-check-label" for="">No Filter</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="1" id="morningRadio">
                                <label class="form-check-label" for="">Morning</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="2" id="eveningRadio">
                                <label class="form-check-label" for="">Evening</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="3" id="nightRadio">
                                <label class="form-check-label" for="">Night</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="4" id="rotatingShift">
                                <label class="form-check-label" for="">Rotating</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioShift" value="5" id="flexibleShit">
                                <label class="form-check-label" for="">Flexible</label>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <hr class="border border-1 border-primary opacity-25">
                        <div class="row mb-2">
                          <div class="col-12">
                            <legend>Education</legend>
                          </div>
                          <div class="col-12">
                            <ul class="list-group">
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioEducation" value="0" id="noneRadio" checked>
                                <label class="form-check-label" for="">No Filter</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioEducation" value="1" id="highSchoolRadio">
                                <label class="form-check-label" for="">High School Diploma</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioEducation" value="2" id="bachelorRadio">
                                <label class="form-check-label" for="">Bachelor's Degree</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioEducation" value="3" id="masterRadio">
                                <label class="form-check-label" for="">Master's Degree</label>
                              </li>
                              <li class="list-group-item">
                                <input class="form-check-input me-1" type="radio" name="radioEducation" value="4" id="phdRadio">
                                <label class="form-check-label" for="">PhD</label>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="col-12 col-lg-9 container ">
                    <div class="container row justify-content-between">
                      <div class="container col-4 m-0">
                        <h5><?php echo count($dataCount) ?> Jobs Found</h4>
                      </div>
                    </div>
                    <?php
                    //var_dump($locationFilters);
                    //var_dump($data);
                    //var_dump($_SESSION['paginationNum']);
                    ?>
                    <?php include "vacanciesPagination.php" ?>
                    <?php include "vacanciesCard.php" ?>
                  </div>
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

        let regionCheckbox = document.getElementById("regionCheckbox");
        let provinceCheckbox = document.getElementById("provinceCheckbox");
        let municipalityCheckbox = document.getElementById("municipalityCheckbox");
        let barangayCheckbox = document.getElementById("barangayCheckbox");

        let fullTimeBtn = document.getElementById("fullTimeBtn");
        let partTimeBtn = document.getElementById("partTimeBtn");
        let contractBtn = document.getElementById("contractBtn");
        let temporaryBtn = document.getElementById("temporaryBtn");
        let remoteBtn = document.getElementById("remoteBtn");
        let freelanceBtn = document.getElementById("freelanceBtn");


        regionCheckbox.addEventListener('change', function() {
          if (regionCheckbox.checked) {
            document.getElementById('regions').disabled = false;

            document.getElementById('regions').style.display = "block";

          } else {
            document.getElementById('regions').disabled = true;
            document.getElementById('provinces').disabled = true;
            document.getElementById('municipalities').disabled = true;
            document.getElementById('barangays').disabled = true;

            document.getElementById('regions').style.display = "none";
            document.getElementById('provinces').style.display = "none";
            document.getElementById('municipalities').style.display = "none";
            document.getElementById('barangays').style.display = "none";

            document.getElementById('provinceCheckbox').checked = false;
            document.getElementById('municipalityCheckbox').checked = false;
            document.getElementById('barangayCheckbox').checked = false;
          }
        })

        provinceCheckbox.addEventListener('change', function() {
          if (provinceCheckbox.checked) {
            document.getElementById('provinces').disabled = false;
            document.getElementById('regions').disabled = false;

            document.getElementById('provinces').style.display = "block";
            document.getElementById('regions').style.display = "block";

            document.getElementById('regionCheckbox').checked = true;
          } else {
            document.getElementById('provinces').disabled = true;
            document.getElementById('municipalities').disabled = true;
            document.getElementById('barangays').disabled = true;

            document.getElementById('provinces').style.display = "none";
            document.getElementById('municipalities').style.display = "none";
            document.getElementById('barangays').style.display = "none";

            document.getElementById('municipalityCheckbox').checked = false;
            document.getElementById('barangayCheckbox').checked = false;
          }
        })

        municipalityCheckbox.addEventListener('change', function() {
          if (municipalityCheckbox.checked) {
            document.getElementById('provinces').disabled = false;
            document.getElementById('regions').disabled = false;
            document.getElementById('municipalities').disabled = false;

            document.getElementById('provinces').style.display = "block";
            document.getElementById('regions').style.display = "block";
            document.getElementById('municipalities').style.display = "block";

            document.getElementById('regionCheckbox').checked = true;
            document.getElementById('provinceCheckbox').checked = true;
          } else {
            document.getElementById('municipalities').disabled = true;
            document.getElementById('barangays').disabled = true;

            document.getElementById('municipalities').style.display = "none";
            document.getElementById('barangays').style.display = "none";

            document.getElementById('barangayCheckbox').checked = false;
          }
        })

        barangayCheckbox.addEventListener('change', function() {
          if (barangayCheckbox.checked) {
            document.getElementById('provinces').disabled = false;
            document.getElementById('regions').disabled = false;
            document.getElementById('municipalities').disabled = false;
            document.getElementById('barangays').disabled = false;

            document.getElementById('provinces').style.display = "block";
            document.getElementById('regions').style.display = "block";
            document.getElementById('municipalities').style.display = "block";
            document.getElementById('barangays').style.display = "block";

            document.getElementById('regionCheckbox').checked = true;
            document.getElementById('provinceCheckbox').checked = true;
            document.getElementById('municipalityCheckbox').checked = true;
          } else {
            document.getElementById('barangays').style.display = "none";

            document.getElementById('barangays').disabled = true;
          }
        })

        fullTimeBtn.addEventListener('change', function() {
          if (fullTimeBtn.checked) {
            partTimeBtn.disabled = true;
            freelanceBtn.disabled = true;
            temporaryBtn.disabled = true;
            contractBtn.disabled = true;
          } else {
            partTimeBtn.disabled = false;
            freelanceBtn.disabled = false;
            temporaryBtn.disabled = false;
            contractBtn.disabled = false;
          }
        })

        partTimeBtn.addEventListener('change', function() {
          if (partTimeBtn.checked) {
            fullTimeBtn.disabled = true;
            freelanceBtn.disabled = true;
            temporaryBtn.disabled = true;
            contractBtn.disabled = true;
          } else {
            fullTimeBtn.disabled = false;
            freelanceBtn.disabled = false;
            temporaryBtn.disabled = false;
            contractBtn.disabled = false;
          }
        })

        contractBtn.addEventListener('change', function() {
          if (contractBtn.checked) {
            fullTimeBtn.disabled = true;
            partTimeBtn.disabled = true;
          } else {
            if (!temporaryBtn.checked && !freelanceBtn.checked) {
              fullTimeBtn.disabled = false;
              partTimeBtn.disabled = false;
            }
          }
        })

        temporaryBtn.addEventListener('change', function() {
          if (temporaryBtn.checked) {
            fullTimeBtn.disabled = true;
            partTimeBtn.disabled = true;
          } else {
            if (!contractBtn.checked && !freelanceBtn.checked) {
              fullTimeBtn.disabled = false;
              partTimeBtn.disabled = false;
            }
          }
        })

        freelanceBtn.addEventListener('change', function() {
          if (freelanceBtn.checked) {
            fullTimeBtn.disabled = true;
            partTimeBtn.disabled = true;
          } else {
            if (!contractBtn.checked && !temporaryBtn.checked) {
              fullTimeBtn.disabled = false;
              partTimeBtn.disabled = false;
            }
          }
        })

        function getProvinces(region_name) {
          $.getJSON("../locations.json", function(result) {
            $.each(result[region_name].province_list, function(key, value) {
              $('#provinces').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
            });
            <?php if ($_SESSION['locationFilters'][1]) {
            ?>
              document.getElementById('provinces').value = '<?php echo $_SESSION['locationFilters'][1] ?>';
              document.getElementById('provinces').dispatchEvent(new Event('change'));
            <?php
            } ?>
            getMunicipality($("#regions").val(), $("#provinces").val());
          });
        }

        function getMunicipality(region_name, province_name) {
          $.getJSON("../locations.json", function(result) {
            // console.log(result[region_name].province_list[province_name]);
            $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
              // console.log(key);
              $('#municipalities').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
            });
            <?php if ($_SESSION['locationFilters'][2]) {
            ?>
              document.getElementById('municipalities').value = '<?php echo $_SESSION['locationFilters'][2] ?>';
              document.getElementById('municipalities').dispatchEvent(new Event('change'));
            <?php
            } ?>
            getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
          });
        }

        function getBarangay(region_name, province_name, municipality_name) {
          $.getJSON("../locations.json", function(result) {
            // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
            $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
              // console.log(key);
              $('#barangays').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
            });
            <?php if ($_SESSION['locationFilters'][3]) {
            ?>
              document.getElementById('barangays').value = '<?php echo $_SESSION['locationFilters'][3] ?>';
              document.getElementById('barangays').dispatchEvent(new Event('change'));
            <?php
            } ?>
          });
        }

        $(document).ready(function() {
          $.getJSON("../locations.json", function(result) {
            $.each(result, function(i, field) {
              $('#regions').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
            });
            <?php if ($_SESSION['locationFilters'][0]) {
            ?>
              document.getElementById('regions').value = '<?php echo $_SESSION['locationFilters'][0] ?>';
              document.getElementById('regions').dispatchEvent(new Event('change'));
            <?php
            } ?>
            //getProvinces($("#regions").val());
            //getMunicipality($("#regions").val(), $("provinces").val());
            //getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
          });

          $("#regions").change(function() {
            $('#provinces').empty();
            $('#municipalities').empty();
            $('#barangays').empty();
            getProvinces($("#regions").val());
          });


          $("#provinces").change(function() {
            $('#municipalities').empty();
            $('#barangays').empty();
            getMunicipality($("#regions").val(), $("#provinces").val());
          });

          $("#municipalities").change(function() {
            $('#barangays').empty();
            getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
          });
        });

        window.onload = function() {
          <?php
          if ($_SESSION['locationFilters'][0] != '') {
          ?>
            document.getElementById('regionCheckbox').checked = true;
            document.getElementById('regionCheckbox').dispatchEvent(new Event('change'));
            document.getElementById('regions').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['locationFilters'][1] != '') {
          ?>
            document.getElementById('provinceCheckbox').checked = true;
            document.getElementById('provinceCheckbox').dispatchEvent(new Event('change'));
            document.getElementById('provinces').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['locationFilters'][2] != '') {
          ?>
            document.getElementById('municipalityCheckbox').checked = true;
            document.getElementById('municipalityCheckbox').dispatchEvent(new Event('change'));
            document.getElementById('municipalities').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['locationFilters'][3] != '') {
          ?>
            document.getElementById('barangayCheckbox').checked = true;
            document.getElementById('barangayCheckbox').dispatchEvent(new Event('change'));
            document.getElementById('barangays').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('fullTime', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('fullTimeBtn').checked = true;
            document.getElementById('fullTimeBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('partTime', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('partTimeBtn').checked = true;
            document.getElementById('partTimeBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('contract', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('contractBtn').checked = true;
            document.getElementById('contractBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('temporary', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('temporaryBtn').checked = true;
            document.getElementById('temporaryBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('remote', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('remoteBtn').checked = true;
            document.getElementById('remoteBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if (in_array('freelance', $_SESSION['jobTypeFilters'])) {
          ?>
            document.getElementById('freelanceBtn').checked = true;
            document.getElementById('freelanceBtn').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['shiftFilter'] == 1) {
          ?>
            document.getElementById('morningRadio').checked = true;
            document.getElementById('morningRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['shiftFilter'] == 2) {
          ?>
            document.getElementById('eveningRadio').checked = true;
            document.getElementById('eveningRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['shiftFilter'] == 3) {
          ?>
            document.getElementById('nightRadio').checked = true;
            document.getElementById('nightRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['shiftFilter'] == 4) {
          ?>
            document.getElementById('rotatingShift').checked = true;
            document.getElementById('rotatingShift').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['shiftFilter'] == 5) {
          ?>
            document.getElementById('flexibleShit').checked = true;
            document.getElementById('flexibleShit').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['educFilter'] == 1) {
          ?>
            document.getElementById('highSchoolRadio').checked = true;
            document.getElementById('highSchoolRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['educFilter'] == 2) {
          ?>
            document.getElementById('bachelorRadio').checked = true;
            document.getElementById('bachelorRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['educFilter'] == 3) {
          ?>
            document.getElementById('masterRadio').checked = true;
            document.getElementById('masterRadio').dispatchEvent(new Event('change'));
          <?php
          }
          if ($_SESSION['educFilter'] == 4) {
          ?>
            document.getElementById('phdRadio').checked = true;
            document.getElementById('phdRadio').dispatchEvent(new Event('change'));
          <?php
          } ?>
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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>



</body>

</html>
