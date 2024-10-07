<?php
$index = 0;
foreach ($data as $dataInstance) {
  if ($index == 5) {
    break;
  }
?>
  <div class="container jobListItem p-3 mt-3 border border-light-subtle">
    <div class="container row m-0">
      <div class="col-2">
        <img src="../../img/companies/<?php echo $dataInstance['img_name'] ?>" width="100" height="100" class="border radius">
      </div>
      <div class="container col-12 col-lg-8 m-0">
        <h4><?php echo $dataInstance['position'] ?></h4>
        <div class="row mt-4">
          <h6 class="col"><?php echo $dataInstance['name'] ?></h6>
          <h6 class="col"><?php echo "Slots: " . $dataInstance['slot_available'] ?></h6>
          <h6 class="col">
            <?php
            if ($dataInstance['job_province']) {
              echo $dataInstance['job_province'];
              if ($dataInstance['job_municipality']) {
                echo ", " . $dataInstance['job_municipality'];
              }
            } else if ($dataInstance['job_municipality']) {
              echo $dataInstance['job_municipality'];
            }
            ?>
          </h6>
        </div>
      </div>
      <div class="col-lg-2 h-100">
        <form action="apply.php" method="POST">
          <button type="submit" class="btn btn-dark mb-3" name="applyButton" value="<?php echo $dataInstance['post_id'] ?>" <?php if ($_SESSION['role'] != 1) {
                                                                                                                              echo "disabled";
                                                                                                                            } ?>>Apply</button>
        </form>
        <h6 class="text-secondary"><?php echo $dataInstance['created_at'] ?></h6>
      </div>
    </div>
  </div>
<?php
  $index++;
} ?>
