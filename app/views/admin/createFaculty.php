<form method="POST" class="row">
  <?php

  use app\controllers\utilsController;

  echo utilsController::renderTextInput('facultyEmail', 'facultyEmail', 'Email', true, '', '', 4, 12);
  echo utilsController::renderTextInput('facultyUsername', 'facultyUsername', 'Username', true, '', '', 4, 12);
  echo utilsController::renderTextInput('facultyFName', 'facultyFName', 'First Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('facultyLName', 'facultyLName', 'Last Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('facultyMName', 'facultyMName', 'Middle Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('facultySuffix', 'facultySuffix', 'Suffix', false, '', '', 4, 12);
  echo utilsController::renderSelect('facultyRegion', 'facultyRegion', 'Region', true, 3, 12);
  echo utilsController::renderSelect('facultyProvince', 'facultyProvince', 'Province', true, 3, 12);
  echo utilsController::renderSelect('facultyMunicipality', 'facultyMunicipality', 'Municipality', true, 3, 12);
  echo utilsController::renderSelect('facultyBarangay', 'facultyBarangay', 'Barangay', true, 3, 12);
  echo utilsController::renderTextInput('facultyStAdd', 'facultyStAdd', 'Street Address', true, '', '', 12, 12);
  echo utilsController::insertAttribute(utilsController::renderTextInput('facultyCPNumber', 'facultyCPNumber', 'Contact Number', true, '', '', 6, 12), "input", "maxlength='11'");
  ?>
  <div class="col-md-6 col-sm-12" id="">
    <label for="facultySex" class="form-label">Sex</label>
    <select class="form-select" id="facultySex" name="facultySex" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>
  <?php
  echo utilsController::renderDateInput('facultyBDate', 'facultyBDate', 'Birth Date', true, '', '', 6, 12);
  echo utilsController::renderSelectWithOptions('facultyCampus', 'facultyCampus', 'Campus', array_map(fn($campus) => ['value' => $campus['campusID'], 'name' => $campus['campusName']], $campuses), '');
  echo utilsController::renderTextInput('facultyID', 'facultyID', 'Faculty ID', true, '', '', 4, 12);
  echo utilsController::renderSelectWithOptions('facultyRank', 'facultyRank', 'Academic Rank', array_map(fn($acadRank) => ['value' => $acadRank['faculty_rank_id'], 'name' => $acadRank['f_rank_description']], $acadRanks), '');
  echo utilsController::renderPasswordInput('facultyPass', 'facultyPass', 'Temporary Password', true, '', '', 6, 12);
  echo utilsController::renderPasswordInput('facultyConfPass', 'facultyConfPass', 'Confirm Temporary Password', true, '', '', 6, 12);
  ?>
  <div class=" col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="faculty">Register Account</button>
  </div>
</form>
