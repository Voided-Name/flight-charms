<?php
if (!isset($vacanciesData[$_GET['editBtnVal']])) {
  Flight::redirect(Flight::request()->base . '/dashboard/employer/jobVacancies');
  exit();
}
?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">Manage Jobs</h4>
            </div>
          </div>
          <div class="card-body px-0">
            <div class="container">
              <form method="POST" action="editJobVacancy">
                <div class="mb-2">
                  <a href="<?= Flight::request()->base ?>/dashboard/employer/jobVacancies"><button type="button" class="btn btn-secondary">
                      Back</button></a>
                </div>
                <div class="row mb-2">
                  <div class="col">
                    <label for="position">Position</label>
                    <input type="text" class="form-control" placeholder="Position" id="position" name="position" required value="<?php echo $vacanciesData[$_GET['editBtnVal']]['position'] ?>">
                  </div>
                  <div class="col">
                    <label for="numVacancies">Number of Vacancies</label>
                    <input type="number" class="form-control" placeholder="Number of Vacancies" id="numVacancies" name="numVacancies" required value="<?php echo $vacanciesData[$_GET['editBtnVal']]['slot_available'] ?>">
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
                        <input class="form-check-input me-1" type="checkbox" value="regionCheckVal" id="regionCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_region']) {
                                                                                                                                                      echo "checked";
                                                                                                                                                    }
                                                                                                                                                    ?>>
                        <label class="form-check-label" for="regionCheckbox">Region</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="provinceCheckVal" id="provinceCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_province']) {
                                                                                                                                                          echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
                        <label class="form-check-label" for="provinceCheckbox">Province</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="municipalityCheckVal" id="municipalityCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_municipality']) {
                                                                                                                                                                  echo "checked";
                                                                                                                                                                }
                                                                                                                                                                ?>>
                        <label class="form-check-label" for="municipalityCheckbox">Municipality</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="barangayCheckVal" id="barangayCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_barangay']) {
                                                                                                                                                          echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
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
                        <input class="form-check-input me-1" type="checkbox" value="fullTime" id="fullTimeBtn" name="jobTypeCheckboxes[]" onchange="fullTimeBtnFunc()" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][0] == '1') ? "checked" : ""; ?>>
                        <label class=" form-check-label" for="">Full-Time</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="partTime" id="partTimeBtn" name="jobTypeCheckboxes[]" onchange="partTimeBtnFunc()" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][1] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Part-Time</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="contract" id="contractBtn" name="jobTypeCheckboxes[]" onchange="contractBtnFunc()" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][2] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Contract</label>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="temporary" id="temporaryBtn" name="jobTypeCheckboxes[]" onchange="temporaryBtnFunc()" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][3] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Temporary</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="remote" id="remoteBtn" name="jobTypeCheckboxes[]" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][4] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Remote</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="freelance" id="freelanceBtn" name="jobTypeCheckboxes[]" onchange="freelanceBtnFunc" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_type'][5] == '1') ? "checked" : ""; ?>>
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
                        <input class="form-check-input me-1" type="radio" name="radioShift" value="1" id="morningRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_shift'] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Morning</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioShift" value="2" id="eveningRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_shift'] == '2') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Evening</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioShift" value="3" id="nightRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_shift'] == '3') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Night</label>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioShift" value="4" id="rotatingShift" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_shift'] == '4') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Rotating</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioShift" value="5" id="flexibleShit" <?php echo ($vacanciesData[$_GET['editBtnVal']]['job_shift'] == '5') ? "checked" : ""; ?>>
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
                  <div class="col-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioEducation" value="1" id="highSchoolRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['education'] == '1') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">High School Diploma</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioEducation" value="2" id="bachelorRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['education'] == '2') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Bachelor's Degree</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioEducation" value="3" id="masterRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['education'] == '3') ? "checked" : ""; ?>>
                        <label class="form-check-label" for="">Master's Degree</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="radio" name="radioEducation" value="4" id="phdRadio" <?php echo ($vacanciesData[$_GET['editBtnVal']]['education'] == '4') ? "checked" : ""; ?>>
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
                      <option value="range" <?php echo ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'range') ? "selected" : ""; ?>>Range</option>
                      <option value="hour" <?php echo ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'hour') ? "selected" : ""; ?>>Hourly</option>
                      <option value="commission" <?php echo ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'commission') ? "selected" : ""; ?>>Commission-Based</option>
                      <option value="negotiable" <?php echo ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'negotiable') ? "selected" : ""; ?>>Negotiable</option>
                    </select>
                  </div>
                  <div class="col-3" id="rangeMinDiv" style="display: none;">
                    <input type="number" class="form-control" placeholder="Php Min" id="rangeMin" name="rangeMin" <?php
                                                                                                                  if ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'range') {
                                                                                                                    echo "value = " . $vacanciesData[$_GET['editBtnVal']]['salary_min'];
                                                                                                                  }
                                                                                                                  ?>>
                  </div>
                  <div class="col-3" id="rangeMaxDiv" style="display: none;">
                    <input type="number" class="form-control" placeholder="Php Max" id="rangeMax" name="rangeMax" <?php
                                                                                                                  if ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'range') {
                                                                                                                    echo "value = " . $vacanciesData[$_GET['editBtnVal']]['salary_max'];
                                                                                                                  }
                                                                                                                  ?>>
                  </div>
                  <div class="col-3" id="phpHourDiv" style="display:none;">
                    <input type="number" class="form-control" placeholder="Php / Hour" id="phpHour" name="phpHour" <?php
                                                                                                                    if ($vacanciesData[$_GET['editBtnVal']]['salary_format'] == 'hour') {
                                                                                                                      echo "value = " . $vacanciesData[$_GET['editBtnVal']]['salary_hour'];
                                                                                                                    }
                                                                                                                    ?>>
                  </div>
                </div>
                <hr class="border border-1 border-primary opacity-25">
                <div class="">
                  <textarea class="form-select form-select-lg mb-3" placeholder="Job Description" id="jobDescription" name="jobDescription" required><?php echo $vacanciesData[$_GET['editBtnVal']]['job_description'] ?></textarea>
                </div>
                <div class="bd-example">
                  <button type="submit" class="btn btn-primary" onclick="" name="editSaveBtn" value="<?php echo $vacanciesData[$_GET['editBtnVal']]['job_id']; ?>">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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

  fullTimeBtn.addEventListener('change', fullTimeBtnFunc());

  function fullTimeBtnFunc() {
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
  }

  partTimeBtn.addEventListener('change', partTimeBtnFunc());

  function partTimeBtnFunc() {
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
  }


  contractBtn.addEventListener('change', contractBtnFunc())


  function contractBtnFunc() {
    if (contractBtn.checked) {
      fullTimeBtn.disabled = true;
      partTimeBtn.disabled = true;
    } else {
      if (!temporaryBtn.checked && !freelanceBtn.checked) {
        fullTimeBtn.disabled = false;
        partTimeBtn.disabled = false;
      }
    }
  }

  temporaryBtn.addEventListener('change', temporaryBtnFunc())

  function temporaryBtnFunc() {
    if (temporaryBtn.checked) {
      fullTimeBtn.disabled = true;
      partTimeBtn.disabled = true;
    } else {
      if (!contractBtn.checked && !freelanceBtn.checked) {
        fullTimeBtn.disabled = false;
        partTimeBtn.disabled = false;
      }
    }
  }

  freelanceBtn.addEventListener('change', freelanceBtnFunc());

  function freelanceBtnFunc() {
    if (freelanceBtn.checked) {
      fullTimeBtn.disabled = true;
      partTimeBtn.disabled = true;
    } else {
      if (!contractBtn.checked && !temporaryBtn.checked) {
        fullTimeBtn.disabled = false;
        partTimeBtn.disabled = false;
      }
    }
  }

  freelanceBtnFunc();
  temporaryBtnFunc();
  contractBtnFunc();
  partTimeBtnFunc();
  fullTimeBtnFunc();

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


  $(document).ready(function() {
    $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
      $.each(result, function(i, field) {
        $('#regions').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
      });
      if (regionCheckbox.checked) {
        $('#regions').prop('disabled', false).show();
        getProvinces($("#regions").val());
      }
      if (provinceCheckbox.checked) {
        $('#provinces').prop('disabled', false).show();
        getMunicipality($("#regions").val(), $("provinces").val());
      }
      if (municipalityCheckbox.checked) {
        $('#municipalities').prop('disabled', false).show();
        getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
      }
      if (barangayCheckbox.checked) {
        $('#barangays').prop('disabled', false).show();
      }


      if (document.getElementById('regionCheckbox').checked) {
        document.getElementById('regions').value = "<?php echo $vacanciesData[$_GET['editBtnVal']]['job_region']; ?>";
      }
      if (document.getElementById('provinceCheckbox').checked) {
        document.getElementById('provinces').value = "<?php echo $vacanciesData[$_GET['editBtnVal']]['job_province']; ?>";
      }
      if (document.getElementById('municipalityCheckbox').checked) {
        document.getElementById('municipalities').value = "<?php echo $vacanciesData[$_GET['editBtnVal']]['job_municipality']; ?>";
      }
      if (document.getElementById('barangayCheckbox').checked) {
        document.getElementById('barangays').value = "<?php echo $vacanciesData[$_GET['editBtnVal']]['job_barangay']; ?>";
      }
    });
    $("#regions").change(function() {
      $('#provinces').empty();
      $('#municipalities').empty();
      $('#barangays').empty();
      getProvinces($("#regions").val());
    });

    function getProvinces(region_name) {
      $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
        console.log("Result: ", result);
        console.log("Region name: ", region_name);
        if (region_name) {
          $.each(result[region_name].province_list, function(key, value) {
            $('#provinces').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getMunicipality($("#regions").val(), $("#provinces").val());
        }
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
        if (region_name && province_name) {
          $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
            // console.log(key);
            $('#municipalities').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
          });
          getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
        }
      });
    }

    $("#municipalities").change(function() {
      $('#barangays').empty();
      getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
    });

    function getBarangay(region_name, province_name, municipality_name) {
      $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
        // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
        if (region_name && province_name && municipality_name) {
          $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
            // console.log(key);
            $('#barangays').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
          });
        }
      });
    }

  });
  if (document.getElementById('regionCheckbox').checked) {
    document.getElementById('regions').value = <?php echo $vacanciesData[$_GET['editBtnVal']]['job_region'] ?>
  }
  if (document.getElementById('provinceCheckbox').checked) {
    document.getElementById('provinces').value = <?php echo $vacanciesData[$_GET['editBtnVal']]['job_province'] ?>
  }
  if (document.getElementById('municipalityCheckbox').checked) {
    document.getElementById('municipalities').value = <?php echo $vacanciesData[$_GET['editBtnVal']]['job_municipality'] ?>
  }
  if (document.getElementById('barangayCheckbox').checked) {
    document.getElementById('barangays').value = <?php echo $vacanciesData[$_GET['editBtnVal']]['job_barangay'] ?>
  }
</script>

</body>

</html>
