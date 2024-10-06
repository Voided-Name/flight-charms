<form method="POST" action="createEmployer" class="row" onsubmit="return validateEmployerPasswords(event)">

  <div class='col-md-4 col-sm-12'>
    <label for='employerEmail' class='form-label'>Email</label>
    <input hx-post="checkEmail" hx-trigger="blur" hx-vals='{"fieldName": "employerEmail"}' hx-on:focus="removeError(this)" type='text' class='form-control' id='employerEmail' name='employerEmail' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='employerUsername' class='form-label'>Username</label>
    <input hx-post="checkUsername" hx-trigger="blur" hx-vals='{"fieldName": "employerUsername"}' hx-on:focus="removeError(this)" type='text' class='form-control' id='employerUsername' name='employerUsername' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='employerFName' class='form-label'>First Name</label>
    <input type='text' class='form-control' id='employerFName' name='employerFName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='employerLName' class='form-label'>Last Name</label>
    <input type='text' class='form-control' id='employerLName' name='employerLName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='employerMName' class='form-label'>Middle Name</label>
    <input type='text' class='form-control' id='employerMName' name='employerMName' value='' placeholder='' required>
  </div>

  <div class='col-md-4 col-sm-12'>
    <label for='employerSuffix' class='form-label'>Suffix</label>
    <input type='text' class='form-control' id='employerSuffix' name='employerSuffix' value='' placeholder=''>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='employerRegion' class='form-label'>Region</label>
    <select class='form-select' id='employerRegion' name='employerRegion' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='employerProvince' class='form-label'>Province</label>
    <select class='form-select' id='employerProvince' name='employerProvince' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='employerMunicipality' class='form-label'>Municipality</label>
    <select class='form-select' id='employerMunicipality' name='employerMunicipality' required>
    </select>
  </div>

  <div class='col-md-3 col-sm-12'>
    <label for='employerBarangay' class='form-label'>Barangay</label>
    <select class='form-select' id='employerBarangay' name='employerBarangay' required>
    </select>
  </div>

  <div class='col-md-12 col-sm-12'>
    <label for='employerStAdd' class='form-label'>Street Address</label>
    <input type='text' class='form-control' id='employerStAdd' name='employerStAdd' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='employerCPNumber' class='form-label'>Contact Number</label>
    <input type='text' class='form-control' id='employerCPNumber' name='employerCPNumber' value='' placeholder='' required maxlength='11'>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='employerBDate' class='form-label'>Birth Date</label>
    <input type='date' class='form-control' id='employerBDate' name='employerBDate' value='' placeholder='' required>
  </div>

  <div class="col-md-6 col-sm-12" id="">
    <label for="employerSex" class="form-label">Sex</label>
    <select class="form-select" id="employerSex" name="employerSex" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>

  <div class="col-md-6 col-sm-12" id="employerCompanyDiv">
    <label for="employerCompany" class="form-label">Company Name</label>
    <select class="form-select" id="employerCompany" name="employerCompany">
      <!-- Options generated from $companies array -->
      <?php foreach ($companies as $company): ?>
        <option value="<?= $company['company_id']; ?>"><?= $company['company_name']; ?></option>
      <?php endforeach; ?>
      <option value="0">Other</option>
    </select>
  </div>

  <div class="col-md-4 col-sm-12" style="display:none" id="companySTRdiv">
    <label for="employerCompanySTR" class="form-label">Add Company Name</label>
    <input id="employerCompanySTR" class="form-control" type="text" name="employerCompanySTR" value="" />
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='employerID' class='form-label'>Employer ID</label>
    <input type='text' class='form-control' id='employerID' name='employerID' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='employerPosition' class='form-label'>Company Position</label>
    <input type='text' class='form-control' id='employerPosition' name='employerPosition' value='' placeholder='' required>
  </div>
  <hr>

  <div class='col-md-6 col-sm-12'>
    <label for='employerPass' class='form-label'>Temporary Password</label>
    <input type='password' class='form-control' id='employerPass' name='employerPass' value='' placeholder='' required>
  </div>

  <div class='col-md-6 col-sm-12'>
    <label for='employerConfPass' class='form-label'>Confirm Temporary Password</label>
    <input type='password' class='form-control' id='employerConfPass' name='employerConfPass' value='' placeholder='' required>
  </div>

  <div class="col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="employer">Register Account</button>
  </div>

</form>
