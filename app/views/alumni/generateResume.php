<?php

?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">Generate Resume</h4>
            </div>
          </div>
          <div class="card-body px-0">
            <form method="POST" action="<?= Flight::request()->base ?>/dashboard/alumni/generateResumePDF">
              <div class="container">
                <hr class="border border-dark border-1">
                <h4 class="ms-3 my-3">Awards</h4>
                <ul class="list-group">
                  <?php
                  if ($alumniAwards) {
                    foreach ($alumniAwards as $alumniAward) {
                  ?>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="<?php echo $alumniAward['award_id'] ?>" id="awardCheckbox" name="awardCheckbox[]">
                        <label class="form-check-label" for="awardCheckbox"><?php echo $alumniAward['award_name'] . " | " . $alumniAward['given_by'] . " | " . $alumniAward['award_date'] ?></label>
                      </li>
                  <?php
                    }
                  } ?>

                </ul>
                <h4 class="ms-3 my-3">Work Experience</h4>
                <ul class="list-group">
                  <?php
                  if ($alumniWorkExperience) {
                    foreach ($alumniWorkExperience as $alumniExperience) {
                  ?>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="<?php echo $alumniExperience['work_exp_id'] ?>" id="experienceCheckbox" name="experienceCheckbox[]">
                        <label class="form-check-label" for="experienceCheckbox"><?php echo $alumniExperience['work_position'] . " | " . $alumniExperience['work_name'] . " | " . $alumniExperience['date_started'] . " - " . $alumniExperience['date_end'] ?></label>
                      </li>
                  <?php
                    }
                  } ?>
                </ul>
                <button type="submit" class="btn btn-primary m-2" name="genRes">Generate PDF</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
</script>

<script src="../../js/core/libs.min.js"></script>
<script src="../../js/core/external.min.js"></script>
<script src="../../js/charts/widgetcharts.js"></script>
<script src="../../js/charts/vectore-chart.js"></script>
<script src="../../js/charts/dashboard.js"></script>
<script src="../../js/plugins/fslightbox.js"></script>
<script src="../../js/plugins/setting.js"></script>
<script src="../../js/plugins/slider-tabs.js"></script>
<script src="../../js/plugins/form-wizard.js"></script>
<script src="../../js/hope-ui.js" defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
</body>

</html>
