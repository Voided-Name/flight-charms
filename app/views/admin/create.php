<?php

$regionInformation = array();
$regionInformation['01'] = 'Region I';
$regionInformation['02'] = 'Region II';
$regionInformation['03'] = 'Region III';
$regionInformation['4A'] = 'Region IV-A';
$regionInformation['4B'] = 'Region IV-B';
$regionInformation['05'] = 'Region V';
$regionInformation['06'] = 'Region VI';
$regionInformation['07'] = 'Region VII';
$regionInformation['08'] = 'Region VII';
$regionInformation['09'] = 'Region XI';
$regionInformation['10'] = 'Region X';
$regionInformation['11'] = 'Region XI';
$regionInformation['12'] = 'Region XII';
$regionInformation['13'] = 'Region XIII';
$regionInformation['BARMM'] = 'BARMM';
$regionInformation['CAR'] = 'CAR';
$regionInformation['NCR'] = 'NCR';

//$courses = $func->selectall('courses');
//$campuses = $func->selectall('campuses');
//$majors = $func->selectall('coursesmajor');
//$mapMajors = array_combine(array_column($majors, 'majorName'), array_column($majors, 'id;'));
//$acadRanks = $func->selectall('faculty_rankings');
//$companies = $func->selectall('companies');

?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <ul class="nav nav-tabs p-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="alumni-tab" data-bs-toggle="tab" data-bs-target="#alumni" type="button" role="tab" aria-controls="alumni" aria-selected="true">Alumni</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="employer-tab" data-bs-toggle="tab" data-bs-target="#employer" type="button" role="tab" aria-controls="employer" aria-selected="false">Employer</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="faculty-tab" data-bs-toggle="tab" data-bs-target="#faculty" type="button" role="tab" aria-controls="faculty" aria-selected="false">Faculty</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="alumni" role="tabpanel" aria-labelledby="alumni-tab">
              <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                  <h4 class="card-title">Create Account</h4>
                </div>
              </div>
              <div class="card-body px-0">
                <div class="container">
                  <?= $createAlumni ?>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="employer" role="tabpanel" aria-labelledby="employer-tab">
              <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                  <h4 class="card-title">Create Account</h4>
                </div>
              </div>
              <div class="card-body px-0">
                <div class="container">
                  <?php //include 'create-employer-tabs.php' 
                  ?>
                  <?= $createEmployer ?>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="faculty" role="tabpanel" aria-labelledby="faculty-tab">
              <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                  <h4 class="card-title">Create Account</h4>
                </div>
              </div>
              <div class="card-body px-0">
                <div class="container">
                  <?= $createFaculty ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
/**
 * @disregard
 */
//d($err);
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if (isset($_SESSION['createValid'])) {
    if ($_SESSION['createValid']) {
      $_SESSION['createValid'] = false;
  ?>
      Swal.fire({
        icon: 'success',
        title: 'Account Created',
        text: 'Check Accounts List'
      });
    <?php
    }
  }
  if (isset($_SESSION['createInvalid'])) {
    if ($_SESSION['createInvalid']) {
      $_SESSION['createInvalid'] = false;
    ?>
      Swal.fire({
        icon: 'error',
        title: 'Account Not Created',
        text: 'Something Went Wrong!'
      });
    <?php
    }
  }
  if ($userNameErr || $emailInvalid || $emailErrExists || $differentPassword) {
    ?>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: '<?php echo $err ?>'
    });
  <?php } ?>
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
      el.value = courseOptionsSpec[x];
      majorOptions.appendChild(el);
    }
  }

  function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for (i = L; i >= 0; i--) {
      selectElement.remove(i);
    }
  }

  let userRoles = ['alumni', 'employer', 'faculty'];

  $(document).ready(function() {
    userRoles.forEach(function(role, index) {
      $('#' + role + 'BDate').focusout(function() {
        var inputDate = new Date($(this).val());
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
            $('#' + role + 'BDate').focus();
          });
        }
      });
    });


    $.getJSON('<?php echo (Flight::request()->base) ?>/assets/locations.json', function(result) {
      $.each(result, function(i, field) {
        userRoles.forEach(function(role, index) {
          $('#' + role + 'Region').append(`<option value="${i}">
                                       ${field.region_name}
                                  </option>`);
        });
      });
      userRoles.forEach(function(role, index) {
        getProvinces($("#" + role + "Region").val(), role);
        getMunicipality($("#" + role + "Region").val(), $("#" + role + "Province").val());
        getBarangay($("#" + role + "Region").val(), $("#" + role + "Province").val(), $("#" + role + "Municipality").val());
      });
    });

    userRoles.forEach(function(role, index) {
      $("#" + role + "Region").change(function() {
        $('#' + role + 'Province').empty();
        $('#' + role + 'Municipality').empty();
        $('#' + role + 'Barangay').empty();
        getProvinces($("#" + role + "Region").val(), role);
      });
    });

    function getProvinces(region_name, role) {
      $.getJSON('<?php echo (Flight::request()->base) ?>/assets/locations.json', function(result) {
        $.each(result[region_name].province_list, function(key, value) {
          $('#' + role + 'Province').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
        });
        getMunicipality($("#" + role + "Region").val(), $("#" + role + "Province").val(), role);
      });
    }

    userRoles.forEach(function(role, index) {
      $("#" + role + "Province").change(function() {
        $('#' + role + 'Municipality').empty();
        $('#' + role + 'Barangay').empty();
        getMunicipality($("#" + role + "Region").val(), $("#" + role + "Province").val(), role);
      });
    });

    function getMunicipality(region_name, province_name, role) {
      $.getJSON('<?php echo (Flight::request()->base) ?>/assets/locations.json', function(result) {
        // console.log(result[region_name].province_list[province_name]);
        $.each(result[region_name].province_list[province_name].municipality_list, function(key, value) {
          // console.log(key);
          $('#' + role + 'Municipality').append(`<option value="${key}">
                                       ${key}
                                  </option>`);
        });
        getBarangay($("#" + role + "Region").val(), $("#" + role + "Province").val(), $("#" + role + "Municipality").val(), role);
      });
    }

    userRoles.forEach(function(role, index) {
      $("#" + role + "Municipality").change(function() {

        $('#' + role + 'Barangay').empty();
        getBarangay($("#" + role + "Region").val(), $("#" + role + "Province").val(), $("#" + role + "Municipality").val(), role);
      });
    });

    function getBarangay(region_name, province_name, municipality_name, role) {
      $.getJSON('<?php echo (Flight::request()->base) ?>/assets/locations.json', function(result) {
        // console.log(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list);
        $.each(result[region_name].province_list[province_name].municipality_list[municipality_name].barangay_list, function(key, value) {
          // console.log(key);
          $('#' + role + 'Barangay').append(`<option value="${value}">
                                       ${value}
                                  </option>`);
        });
      });
    }
  });

  companyNameSel = document.getElementById("employerCompany");
  companyNameSel.addEventListener("change", function() {
    updateCompanyName(false)
  });

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

  updateCompanyName(true);

  function changeTab() {
    if (sessionStorage.getItem('createAccTab') == 'alumni') {
      let alumniTab = new bootstrap.Tab(document.getElementById('alumni-tab'));
      alumniTab.show();
    } else if (sessionStorage.getItem('createAccTab') == 'employer') {
      let employerTab = new bootstrap.Tab(document.getElementById('employer-tab'));
      employerTab.show();
    } else if (sessionStorage.getItem('createAccTab') == 'faculty') {
      let facultyTab = new bootstrap.Tab(document.getElementById('faculty-tab'));
      facultyTab.show();
    }
  }

  document.getElementById('alumni-tab').addEventListener('click', function() {
    sessionStorage.setItem('createAccTab', 'alumni');
  });

  document.getElementById('employer-tab').addEventListener('click', function() {
    sessionStorage.setItem('createAccTab', 'employer');
  });

  document.getElementById('faculty-tab').addEventListener('click', function() {
    sessionStorage.setItem('createAccTab', 'faculty');
  });

  changeTab();


  function removeError($el) {
    $el.classList.remove("err");
  }

  document.body.addEventListener('htmx:afterRequest', function(event) {
    const responseText = event.detail.xhr.responseText;

    const requestURL = event.detail.xhr.responseURL;

    const triggeringElement = event.detail.elt;

    if (triggeringElement.id == "alumniEmail") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Email Exists!',
          text: 'Login if you are already a user'
        });
      }
    } else if (triggeringElement.id == "alumniUsername") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Username Exists!',
          text: 'Login if you are already a user'
        });
      }
    } else if (triggeringElement.id == "employerEmail") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Email Exists!',
          text: 'Login if you are already a user'
        });
      }
    } else if (triggeringElement.id == "employerUsername") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Username Exists!',
          text: 'Login if you are already a user'
        });
      }
    } else if (triggeringElement.id == "facultyEmail") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Email Exists!',
          text: 'Login if you are already a user'
        });
      }
    } else if (triggeringElement.id == "facultyUsername") {
      if (responseText == "exists") {
        triggeringElement.classList.add("err");
        Swal.fire({
          icon: 'error',
          title: 'Username Exists!',
          text: 'Login if you are already a user'
        });
      }
    }
  });

  function validateAlumniPasswords(event) {
    const password = document.getElementById('alumniPass').value;
    const confirmPassword = document.getElementById('alumniConfPass').value;

    if (password !== confirmPassword) {
      // Prevent the form submission
      event.preventDefault();

      // Display an alert (can use SweetAlert for a better UI)
      Swal.fire({
        icon: 'error',
        title: 'Passwords do not match',
        text: 'Please make sure the passwords are identical.'
      });

      return false; // Prevent form from submitting
    }

    // Allow form submission if passwords match
    return true;
  }

  function validateEmployerPasswords(event) {
    const password = document.getElementById('employerPass').value;
    const confirmPassword = document.getElementById('employerConfPass').value;

    if (password !== confirmPassword) {
      // Prevent the form submission
      alert(password);
      alert(confirmPassword);
      event.preventDefault();

      // Display an alert (can use SweetAlert for a better UI)
      Swal.fire({
        icon: 'error',
        title: 'Passwords do not match',
        text: 'Please make sure the passwords are identical.'
      });

      return false; // Prevent form from submitting
    }

    // Allow form submission if passwords match
    return true;
  }

  function validateFacultyPasswords(event) {
    const password = document.getElementById('facultyPass').value;
    const confirmPassword = document.getElementById('facultyConfPass').value;

    if (password !== confirmPassword) {
      // Prevent the form submission
      event.preventDefault();

      // Display an alert (can use SweetAlert for a better UI)
      Swal.fire({
        icon: 'error',
        title: 'Passwords do not match',
        text: 'Please make sure the passwords are identical.'
      });

      return false; // Prevent form from submitting
    }

    // Allow form submission if passwords match
    return true;
  }
</script>
