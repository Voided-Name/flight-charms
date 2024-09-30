<form method="POST" class="row">
  <?php

  use app\controllers\utilsController;

  echo utilsController::renderTextInput('alumniEmail', 'alumniEmail', 'Email', true, '', '', 4, 12);
  echo utilsController::renderTextInput('alumniUsername', 'alumniUsername', 'Username', true, '', '', 4, 12);
  echo utilsController::renderTextInput('alumniFName', 'alumniFName', 'First Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('alumniLName', 'alumniLName', 'Last Name', true, '', '', 4, 12);
  echo utilsController::renderTextInput('alumniMName', 'alumniMName', 'Middle Name', false, '', '', 4, 12);
  echo utilsController::renderTextInput('alumniSuffix', 'alumniSuffix', 'Suffix', false, '', '', 4, 12);
  echo utilsController::renderSelect('alumniRegion', 'alumniRegion', 'Region', true, 3, 12);
  echo utilsController::renderSelect('alumniProvince', 'alumniProvince', 'Province', true, 3, 12);
  echo utilsController::renderSelect('alumniMunicipality', 'alumniMunicipality', 'Municipality', true, 3, 12);
  echo utilsController::renderSelect('alumniBarangay', 'alumniBarangay', 'Barangay', true, 3, 12);
  echo utilsController::renderTextInput('alumniStAdd', 'alumniStAdd', 'Street Address', true, '', '', 12, 12);
  echo utilsController::insertAttribute(utilsController::renderTextInput('alumniCPNumber', 'alumniCPNumber', 'Contact Number', true, '', '', 3, 12), "input", "maxlength='11'");
  ?>
  <div class="col-md-3 col-sm-12" id="">
    <label for="alumniSex" class="form-label">Sex</label>
    <select class="form-select" id="alumniSex" name="alumniSex" required>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  </div>
  <?php
  echo utilsController::renderDateInput('alumniBDate', 'alumniBDate', 'Birth Date', true, '', '', 6, 12);
  echo utilsController::renderTextInput('alumniStudId', 'alumniStudId', 'Alumni ID', true, '', '', 4, 12);
  echo utilsController::renderSelectWithOptions('alumniCourse', 'alumniCourse', 'Course', array_map(fn($course) => ['value' => $course['courseID'], 'name' => $course['courseName']], $courses), $alumniData[0]['course_id']);
  ?>
  <div class="col-md-4 col-sm-12" id="">
    <label for="alumniMajor" class="form-label">Major</label>
    <select class="form-select" id="alumniMajor" name="alumniMajor">
      <option value="N/A">N/A</option>
    </select>
  </div>
  <?php
  echo utilsController::renderSelectWithOptions('alumniCampus', 'alumniCampus', 'Campus', array_map(fn($campus) => ['value' => $campus['campusID'], 'name' => $campus['campusName']], $campuses), $alumniData[0]['campus']);
  echo utilsController::renderNumberInput('alumniGraduated', 'alumniGraduated', 'Year Graduated', true, '', '', 4, 12);
  echo utilsController::renderNumberInput('alumniEnrolled', 'alumniEnrolled', 'Year Enrolled', true, '', '', 4, 12);
  echo utilsController::renderPasswordInput('alumniPass', 'alumniPass', 'Temporary Password', true, '', '', 6, 12);
  echo utilsController::renderPasswordInput('alumniConfPass', 'alumniConfPass', 'Confirm Temporary Password', true, '', '', 6, 12);
  ?>
  <div class=" col-sm-12 container m-0 my-2">
    <button type="submit" class="btn btn-success" name="register" value="alumni">Register Account</button>
  </div>
</form>
