<?php


if (isset($_POST['submitBtn'])) {
  $position = $strip->strip($_POST['position']);
  $slots = $strip->strip($_POST['numVacancies']);

  $locationCheckboxes = $_POST['locationCheckboxes'];

  if (in_array("regionCheckVal", $locationCheckboxes)) {
    $region = $strip->strip($_POST['regions']);
  }
  if (in_array("provinceCheckVal", $locationCheckboxes)) {
    $province = $strip->strip($_POST['provinces']);
  }
  if (in_array("municipalityCheckVal", $locationCheckboxes)) {
    $municipality = $strip->strip($_POST['municipalities']);
  }
  if (in_array("barangayCheckVal", $locationCheckboxes)) {
    $barangay = $strip->strip($_POST['barangays']);
  }

  $jobTypeCheckboxes = $_POST['jobTypeCheckboxes'];
  $jobType = "000000";

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


  $shift = $strip->strip($_POST['radioShift']);

  $education = $strip->strip($_POST['radioEducation']);

  $salaryFormat = $strip->strip($_POST['salaryFormat']);

  if ($salaryFormat == "range") {
    $rangeSalaryMin = $strip->strip($_POST['rangeMin']);
    $rangeSalaryMax = $strip->strip($_POST['rangeMax']);
  } else if ($salaryFormat == "hour") {
    $hourlySalary = $strip->strip($_POST['phpHour']);
  }

  $description = $strip->strip($_POST['jobDescription']);

  if (!$job_shift) {
    $job_shift = "0";
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

  function deZero($var)
  {
    if (!$var) {
      return "0";
    } else {
      return $var;
    }
  }

  $region = deZero($region);
  $province = deZero($province);
  $municipality = deZero($municipality);
  $barangay = deZero($barangay);

  $input = array(
    'author_id' => $_SESSION['userid'],
    'education' => $education,
    'position' => $position,
    'slot_available' => $slots,
    'job_type' => $jobType,
    'job_shift' => $shift,
    'salary_format' => $salaryFormat,
    'salary_min' => $rangeSalaryMin,
    'salary_max' => $rangeSalaryMax,
    'salary_hour' => $hourlySalary,
    'job_description' => $description,
    'job_region' => $region,
    'job_province' => $province,
    'job_municipality' => $municipality,
    'job_barangay' => $barangay,
    'is_draft' => 0,
    'created_at' => date('Y-m-d'),
  );

  $insertJobVacancy  = $func->insert('employer_job_posts', $input);

  if ($insertJobVacancy) {
    $jobCreated = true;
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
</head>

<div class="container-fluid content-inner mt-n5 py-0">
  <div>
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <div class="header-title">
          <h4 class="card-title">Create a New Job Vacancy</h4>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="createVacancySubmit">
          <div class="row mb-2">
            <div class="col">
              <input type="text" class="form-control" placeholder="Position" id="position" name="position" required>
            </div>
            <div class="col">
              <input type="number" class="form-control" placeholder="Number of Vacancies" id="numVacancies" name="numVacancies" required>
            </div>
          </div>
          <hr class="border border-1 border-primary opacity-25">
          <div class="row mb-2">
            <div class="col-12">
              <legend>Location of Deployment</legend>
            </div>
            <div class="col-6">
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
            <div class="col-6">
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
            <div class="col-6">
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
              </ul>
            </div>
            <div class="col-6">
              <ul class="list-group">
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
            <div class="col-6">
              <ul class="list-group">
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
              </ul>
            </div>
            <div class="col-6">
              <ul class="list-group">
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
              <legend>Education (required)</legend>
            </div>
            <div class="col-6">
              <ul class="list-group">
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
          <hr class="border border-1 border-primary opacity-25">
          <div class="row mb-2">
            <div class="col-12">
              <legend>Salary</legend>
            </div>
            <div class="col-6">
              <select class="form-select" id="salaryFormat" name="salaryFormat">
                <option selected="" disabled>Format</option>
                <option value="range">Range</option>
                <option value="hour">Hourly</option>
                <option value="commission">Commission-Based</option>
                <option value="negotiable">Negotiable</option>
              </select>
            </div>
            <div class="col-3" id="rangeMinDiv" style="display: none;">
              <input type="number" class="form-control" placeholder="Php Min" id="rangeMin" name="rangeMin">
            </div>
            <div class="col-3" id="rangeMaxDiv" style="display: none;">
              <input type="number" class="form-control" placeholder="Php Max" id="rangeMax" name="rangeMax">
            </div>
            <div class="col-3" id="phpHourDiv" style="display:none;">
              <input type="number" class="form-control" placeholder="Php / Hour" id="phpHour" name="phpHour">
            </div>
          </div>
          <hr class="border border-1 border-primary opacity-25">
          <div class="">
            <textarea class="form-select form-select-lg mb-3" placeholder="Job Description" id="jobDescription" name="jobDescription" required></textarea>
          </div>
          <div class="bd-example">
            <button type="submit" class="btn btn-primary" onclick="" name="submitBtn" value="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    <?php
    /*if ($jobCreated) {*/
    /*  echo "showAlert();\n";*/
    /*}*/
    ?>

    function showAlert() {
      Swal.fire({
        title: 'Success',
        text: 'The job is successfully added',
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

    let salaryFormat = document.getElementById("salaryFormat");

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

    salaryFormat.addEventListener('change', function() {
      if (salaryFormat.value == "range") {
        document.getElementById("rangeMaxDiv").style.display = "block";
        document.getElementById("rangeMinDiv").style.display = "block";

        document.getElementById("phpHourDiv").style.display = "none";
      } else if (salaryFormat.value == "hour") {
        document.getElementById("rangeMaxDiv").style.display = "none";
        document.getElementById("rangeMinDiv").style.display = "none";

        document.getElementById("phpHourDiv").style.display = "block";
      } else if (salaryFormat.value == "commission") {
        document.getElementById("rangeMaxDiv").style.display = "none";
        document.getElementById("rangeMinDiv").style.display = "none";


        document.getElementById("phpHourDiv").style.display = "none";
      } else if (salaryFormat.value == "negotiable") {
        document.getElementById("rangeMaxDiv").style.display = "none";
        document.getElementById("rangeMinDiv").style.display = "none";

        document.getElementById("phpHourDiv").style.display = "none";
      }
    })


    $(document).ready(function() {
      $.getJSON("<?php echo Flight::request()->base ?>/assets/locations.json", function(result) {
        $.each(result, function(i, field) {
          $('#regions').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
        });
        getProvinces($("#regions").val());
        getMunicipality($("#regions").val(), $("provinces").val());
        getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
      });

      $("#regions").change(function() {
        $('#provinces').empty();
        $('#municipalities').empty();
        $('#barangays').empty();
        getProvinces($("#regions").val());
      });

      function getProvinces(region_name) {
        $.getJSON("<?php echo Flight::request()->base ?>/assets/locations.json", function(result) {
          $.each(result[region_name].province_list, function(key, value) {
            $('#provinces').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getMunicipality($("#regions").val(), $("#provinces").val());
        });
      }

      $("#provinces").change(function() {
        $('#municipalities').empty();
        $('#barangays').empty();
        getMunicipality($("#regions").val(), $("#provinces").val());
      });

      function getMunicipality(region_name, province_name) {
        $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
          // console.log(result[region_name].province_list[province_name]);
          $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
            // console.log(key);
            $('#municipalities').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
        });
      }

      $("#municipalities").change(function() {

        $('#barangays').empty();
        getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
      });

      function getBarangay(region_name, province_name, municipality_name) {
        $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
          // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
          $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
            // console.log(key);
            $('#barangays').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
          });
        });
      }

    });
    <?php if (isset($_SESSION['jobVacancyCreated'])) {
      if ($_SESSION['jobVacancyCreated']) { ?>
        Swal.fire({
          icon: "success",
          title: "Created",
          text: "Job is successfully created"
        })
    <?php
        $_SESSION['jobVacancyCreated'] = false;
      }
    } ?>

    <?php if (isset($_SESSION['jobVacancyNotCreated'])) {
      if ($_SESSION['jobVacancyNotCreated']) { ?>
        Swal.fire({
          icon: "error",
          title: "Not Created!",
          text: "Check your input fields"
        })
    <?php
        $_SESSION['jobVacancyNotCreated'] = false;
      }
    } ?>
  </script>


  </body>

</html>
