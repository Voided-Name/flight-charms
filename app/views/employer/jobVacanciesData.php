<?php

/**
 * 
 * @var array $vacanciesData
 */
$index = 0;
foreach ($vacanciesData as $vacancyData) {
?>
  <tr>
    <td><?php echo $vacancyData['position'] ?></td>
    <td><?php echo $vacancyData['slot_available'] ?></td>
    <?php
    // $locationArr = array();
    //
    // if ($vacancyData['job_region']) {
    //   array_push($locationArr, $regionInformation[$vacancyData['job_region']]);
    // }
    // if ($vacancyData['job_province']) {
    //   array_push($locationArr, $vacancyData['job_province']);
    // }
    // if ($vacancyData['job_municipality']) {
    //   array_push($locationArr, $vacancyData['job_municipality']);
    // }
    // if ($vacancyData['job_barangay']) {
    //   array_push($locationArr, $vacancyData['job_barangay']);
    // }
    //
    // echo implode(", ", $locationArr);
    ?>
    <td>
      <div class="flex align-items-center list-user-action">
        <!-- Edit Button -->
        <a class="btn btn-sm btn-icon" href="#">
          <div class="bd-example">
            <form method="GET" action="jobVacanciesEdit">
              <button type="submit" class="btn btn-success btn-sm" name="editBtnVal" value="<?php echo $index ?>">Edit</button>
            </form>
          </div>
        </a>
        <a class="btn btn-sm btn-icon" href="#">
          <div class="bd-example">
            <form method="GET" action="viewApps">
              <button type="submit" class="btn btn-primary btn-sm" name="viewBtnVal" value="<?php echo $vacancyData['job_id'] ?>">View</button>
            </form>
          </div>
        </a>
        <a class="btn btn-sm btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" href="#">
          <span class="btn-inner">
            <div class="bd-example">
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteVacancyModal<?php echo $vacancyData['job_id'] ?>">Delete</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="deleteVacancyModal<?php echo $vacancyData['job_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteVacancyTitle">Are you sure you want to delete this vacancy?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h3><?php echo $vacancyData['position'] ?></h3>
                    <h4>Number of Vacancy: <?php echo $vacancyData['slot_available'] ?></h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="GET" action="deleteVacancy">
                      <button type="submit" class="btn btn-danger" name="deleteVacancyBtn" value="<?php echo $vacancyData['job_id'] ?>">Confirm</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </span>
        </a>
      </div>
    </td>
  </tr>
<?php
  $index++;
} ?>
