<form method="POST" class="row">
  <?php

  use app\controllers\utilsController;

  echo utilsController::renderTextInput('employerEmail', 'employerEmail', 'Email', true, '', '', 4, 12);
  echo utilsController::renderTextInput('employerUsername', 'employerUsername', 'Username', true, '', '', 4, 12);
  echo utilsController::renderTextInput('employerFName', 'employerFName', 'First Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('employerLName', 'employerLName', 'Last Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('employerMName', 'employerMName', 'Middle Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('employerSuffix', 'employerSuffix', 'Suffix', false, '', '', 4, 12);
  echo utilsController::renderSelect('employerRegion', 'employerRegion', 'Region', true, 3, 12);
  echo utilsController::renderSelect('employerProvince', 'employerProvince', 'Province', true, 3, 12);
  echo utilsController::renderSelect('employerMunicipality', 'employerMunicipality', 'Municipality', true, 3, 12);
  echo utilsController::renderSelect('employerBarangay', 'employerBarangay', 'Barangay', true, 3, 12);
  echo utilsController::renderTextInput('employerStAdd', 'employerStAdd', 'Street Address', true, '', '', 12, 12);
  echo utilsController::insertAttribute(utilsController::renderTextInput('employerCPNumber', 'employerCPNumber', 'Contact Number', true, '', '', 6, 12), "input", "maxlength='11'");
  echo utilsController::renderDateInput('employerBDate', 'employerBDate', 'Birth Date', true, '', '', 6, 12);
  ?>
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
      <?php
      foreach ($companies as $company) { ?>
        <option value="<?php echo $company['company_id'] ?>"><?php echo $company['company_name'] ?></option>
      <?php
      }
      ?>
      <option value="0">Other</option>
    </select>
  </div>
  <div class="col-md-4 col-sm-12" style="display:none" id="companySTRdiv">
    <label for="employerCompanySTR" class="form-label">Add Company Name</label>
    <input id="employerCompanySTR" class="form-control" type="text" name="employerCompanySTR" value="" />
  </div>
  <?php
  echo utilsController::renderTextInput('employerID', 'employerID', 'Employer ID', true, '', '', 6, 12);
  echo utilsController::renderTextInput('employerPosition', 'employerPosition', 'Company Position', true, '', '', 6, 12);
  echo '<hr>';
  echo utilsController::renderPasswordInput('employerPass', 'employerPass', 'Temporary Password', true, '', '', 6, 12);
  echo utilsController::renderPasswordInput('employerConfPass', 'employerConfPass', 'Confirm Temporary Password', true, '', '', 6, 12);
  ?>
  <div class=" col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="employer">Register Account</button>
  </div>
</form>
