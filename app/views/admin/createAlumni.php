<form method="POST" action="createAlumni" class="row" onsubmit="return validateAlumniPasswords(event)">

  <div class='col-md-4 col-sm-12'>
    <label for='alumniEmail' class='form-label'>Email</label>
    <input hx-post="checkEmail" hx-trigger="blur" hx-vals='{"fieldName": "alumniEmail"}' hx-on:focus="removeError(this)" hx-on="emailExists: alert('this email already exists!')" type='text' class='form-control' id='alumniEmail' name='alumniEmail' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniUsername' class='form-label'>Username</label>
    <input hx-post="checkUsername" hx-trigger="blur" hx-vals='{"fieldName": "alumniUsername"}' hx-on:focus="removeError(this)" type='text' class='form-control' id='alumniUsername' name='alumniUsername' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniFName' class='form-label'>First Name</label>
    <input type='text' class='form-control' id='alumniFName' name='alumniFName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniLName' class='form-label'>Last Name</label>
    <input type='text' class='form-control' id='alumniLName' name='alumniLName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniMName' class='form-label'>Middle Name</label>
    <input type='text' class='form-control' id='alumniMName' name='alumniMName' value='' placeholder=''>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniSuffix' class='form-label'>Suffix</label>
    <input type='text' class='form-control' id='alumniSuffix' name='alumniSuffix' value='' placeholder=''>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='alumniRegion' class='form-label'>Region</label>
    <select class='form-select' id='alumniRegion' name='alumniRegion' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='alumniProvince' class='form-label'>Province</label>
    <select class='form-select' id='alumniProvince' name='alumniProvince' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='alumniMunicipality' class='form-label'>Municipality</label>
    <select class='form-select' id='alumniMunicipality' name='alumniMunicipality' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='alumniBarangay' class='form-label'>Barangay</label>
    <select class='form-select' id='alumniBarangay' name='alumniBarangay' required>
    </select>
  </div>

  <div class='col-md-12 col-sm-12'>
    <label for='alumniStAdd' class='form-label'>Street Address</label>
    <input type='text' class='form-control' id='alumniStAdd' name='alumniStAdd' value='' placeholder='' required>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='alumniCPNumber' class='form-label'>Contact Number</label>
    <input type='text' class='form-control' id='alumniCPNumber' name='alumniCPNumber' value='' placeholder='' required maxlength='11'>
  </div>

  <div class="col-md-3 col-sm-12" id="">
    <label for="alumniSex" class="form-label">Sex</label>
    <select class="form-select" id="alumniSex" name="alumniSex" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='alumniBDate' class='form-label'>Birth Date</label>
    <input type='date' class='form-control' id='alumniBDate' name='alumniBDate' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniStudId' class='form-label'>Alumni ID</label>
    <input type='text' class='form-control' id='alumniStudId' name='alumniStudId' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniCourse' class='form-label'>Course</label>
    <select class='form-select' id='alumniCourse' name='alumniCourse'>
      <!-- Options generated from $courses array -->
      <?php foreach ($courses as $course): ?>
        <option value="<?= $course['courseID']; ?>"><?= $course['courseName']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4 col-sm-12" id="">
    <label for="alumniMajor" class="form-label">Major</label>
    <select class="form-select" id="alumniMajor" name="alumniMajor">
      <option value="N/A">N/A</option>
    </select>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniCampus' class='form-label'>Campus</label>
    <select class='form-select' id='alumniCampus' name='alumniCampus'>
      <!-- Options generated from $campuses array -->
      <?php foreach ($campuses as $campus): ?>
        <option value="<?= $campus['campusID']; ?>"><?= $campus['campusName']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniGraduated' class='form-label'>Year Graduated</label>
    <input type='number' class='form-control' id='alumniGraduated' name='alumniGraduated' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='alumniEnrolled' class='form-label'>Year Enrolled</label>
    <input type='number' class='form-control' id='alumniEnrolled' name='alumniEnrolled' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='alumniPass' class='form-label'>Temporary Password</label>
    <input type='password' class='form-control' id='alumniPass' name='alumniPass' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='alumniConfPass' class='form-label'>Confirm Temporary Password</label>
    <input type='password' class='form-control' id='alumniConfPass' name='alumniConfPass' value='' placeholder='' required>
  </div>

  <div class="col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="alumni" action="createAlumni">Register Account</button>
  </div>

</form>
