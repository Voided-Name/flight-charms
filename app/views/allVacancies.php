<?php
$_SESSION['employerPage'] = 'allVacancies';


?>

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
                  <form method="GET">
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
                    <h5><?php echo $dataCount ?> Jobs Found</h4>
                  </div>
                </div>
                <?php
                //var_dump($locationFilters);
                //var_dump($data);
                //var_dump($_SESSION['paginationNum']);
                ?>
                <?= $allVacanciesPagination ?>
                <?= $allVacanciesCard ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
    $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
      $.each(result[region_name].province_list, function(key, value) {
        $('#provinces').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
      });
      <?php if (isset($_SESSION['locationFilters'][1])) {
        if ($_SESSION['locationFilters'][1] != '') {
      ?>
          document.getElementById('provinces').value = '<?php echo $_SESSION['locationFilters'][1] ?>';
          document.getElementById('provinces').dispatchEvent(new Event('change'));
      <?php
        }
      } ?>
      getMunicipality($("#regions").val(), $("#provinces").val());
    });
  }

  function getMunicipality(region_name, province_name) {
    $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
      // console.log(result[region_name].province_list[province_name]);
      $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
        // console.log(key);
        $('#municipalities').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
      });
      <?php if (isset($_SESSION['locationFilters'][2])) {
        if ($_SESSION['locationFilters'][2] != '') {
      ?>
          document.getElementById('municipalities').value = '<?php echo $_SESSION['locationFilters'][2] ?>';
          document.getElementById('municipalities').dispatchEvent(new Event('change'));
      <?php
        }
      } ?>
      getBarangay($("#regions").val(), $("#provinces").val(), $("#municipalities").val());
    });
  }

  function getBarangay(region_name, province_name, municipality_name) {
    $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
      // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
      $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
        // console.log(key);
        $('#barangays').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
      });
      <?php if (isset($_SESSION['locationFilters'][3])) {
        if ($_SESSION['locationFilters'][3] != '') {
      ?>
          document.getElementById('barangays').value = '<?php echo $_SESSION['locationFilters'][3] ?>';
          document.getElementById('barangays').dispatchEvent(new Event('change'));
      <?php
        }
      } ?>
    });
  }

  $(document).ready(function() {
    $.getJSON("<?= Flight::request()->base ?>/assets/locations.json", function(result) {
      $.each(result, function(i, field) {
        $('#regions').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
      });
      <?php if (isset($_SESSION['locationFilters'][0])) {
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
    if (isset($_SESSION['locationFilters'][0])) {
      if ($_SESSION['locationFilters'][0] != '') {
    ?>
        document.getElementById('regionCheckbox').checked = true;
        document.getElementById('regionCheckbox').dispatchEvent(new Event('change'));
        document.getElementById('regions').dispatchEvent(new Event('change'));
      <?php
      }
    }
    if (isset($_SESSION['locationFilters'][1])) {
      if ($_SESSION['locationFilters'][1] != '') {
      ?>
        document.getElementById('provinceCheckbox').checked = true;
        document.getElementById('provinceCheckbox').dispatchEvent(new Event('change'));
        document.getElementById('provinces').dispatchEvent(new Event('change'));
      <?php
      }
    }
    if (isset($_SESSION['locationFilters'][2])) {
      if ($_SESSION['locationFilters'][2] != '') {
      ?>
        document.getElementById('municipalityCheckbox').checked = true;
        document.getElementById('municipalityCheckbox').dispatchEvent(new Event('change'));
        document.getElementById('municipalities').dispatchEvent(new Event('change'));
      <?php
      }
    }
    if (isset($_SESSION['locationFilters'][3])) {
      if ($_SESSION['locationFilters'][3] != '') {
      ?>
        document.getElementById('barangayCheckbox').checked = true;
        document.getElementById('barangayCheckbox').dispatchEvent(new Event('change'));
        document.getElementById('barangays').dispatchEvent(new Event('change'));
        <?php
      }
    }
    if (isset($_SESSION['jobTypeFilters'])) {
      if ($_SESSION['jobTypeFilters']) {
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
      }
    }
    if (isset($_SESSION['shiftFilter'])) {
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
    }
    if (isset($_SESSION['educFilter'])) {
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
      }
    } ?>
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>

</body>

</html>
