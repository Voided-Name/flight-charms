<form method="POST" action="createFaculty" class="row" onsubmit="return validateFacultyPasswords(event)">

  <div class='col-md-4 col-sm-12'>
    <label for='facultyEmail' class='form-label'>Email</label>
    <input hx-post="checkEmail" hx-trigger="blur" hx-vals='{"fieldName": "facultyEmail"}' hx-on:focus="removeError(this)" type='text' class='form-control' id='facultyEmail' name='facultyEmail' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyUsername' class='form-label'>Username</label>
    <input hx-post="checkUsername" hx-trigger="blur" hx-vals='{"fieldName": "facultyUsername"}' hx-on:focus="removeError(this)" type='text' class='form-control' id='facultyUsername' name='facultyUsername' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyFName' class='form-label'>First Name</label>
    <input type='text' class='form-control' id='facultyFName' name='facultyFName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyLName' class='form-label'>Last Name</label>
    <input type='text' class='form-control' id='facultyLName' name='facultyLName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyMName' class='form-label'>Middle Name</label>
    <input type='text' class='form-control' id='facultyMName' name='facultyMName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultySuffix' class='form-label'>Suffix</label>
    <input type='text' class='form-control' id='facultySuffix' name='facultySuffix' value='' placeholder=''>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='facultyRegion' class='form-label'>Region</label>
    <select class='form-select' id='facultyRegion' name='facultyRegion' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='facultyProvince' class='form-label'>Province</label>
    <select class='form-select' id='facultyProvince' name='facultyProvince' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='facultyMunicipality' class='form-label'>Municipality</label>
    <select class='form-select' id='facultyMunicipality' name='facultyMunicipality' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='facultyBarangay' class='form-label'>Barangay</label>
    <select class='form-select' id='facultyBarangay' name='facultyBarangay' required>
    </select>
  </div>

  <div class='col-md-12 col-sm-12'>
    <label for='facultyStAdd' class='form-label'>Street Address</label>
    <input type='text' class='form-control' id='facultyStAdd' name='facultyStAdd' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='facultyCPNumber' class='form-label'>Contact Number</label>
    <input type='text' class='form-control' id='facultyCPNumber' name='facultyCPNumber' value='' placeholder='' required maxlength='11'>
  </div>

  <div class="col-md-6 col-sm-12" id="">
    <label for="facultySex" class="form-label">Sex</label>
    <select class="form-select" id="facultySex" name="facultySex" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='facultyBDate' class='form-label'>Birth Date</label>
    <input type='date' class='form-control' id='facultyBDate' name='facultyBDate' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyCampus' class='form-label'>Campus</label>
    <select class='form-select' id='facultyCampus' name='facultyCampus'>
      <!-- Options generated from $campuses array -->
      <?php foreach ($campuses as $campus): ?>
        <option value="<?= $campus['campusID']; ?>"><?= $campus['campusName']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyID' class='form-label'>Faculty ID</label>
    <input type='text' class='form-control' id='facultyID' name='facultyID' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='facultyRank' class='form-label'>Academic Rank</label>
    <select class='form-select' id='facultyRank' name='facultyRank'>
      <!-- Options generated from $acadRanks array -->
      <?php foreach ($acadRanks as $acadRank): ?>
        <option value="<?= $acadRank['faculty_rank_id']; ?>"><?= $acadRank['f_rank_description']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='facultyPass' class='form-label'>Temporary Password</label>
    <input type='password' class='form-control' id='facultyPass' name='facultyPass' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='facultyConfPass' class='form-label'>Confirm Temporary Password</label>
    <input type='password' class='form-control' id='facultyConfPass' name='facultyConfPass' value='' placeholder='' required>
  </div>

  <div class="col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="faculty">Register Account</button>
  </div>

</form>
