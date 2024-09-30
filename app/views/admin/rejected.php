<?php bdump($rejectedAll) ?>
<div class="card-header d-flex justify-content-between">
  <div class="header-title">
    <h4 class="card-title">Validate Alumni Account</h4>
  </div>
</div>
<div class="card-body px-0">
  <div class="table-responsive">
    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
      <thead>
        <tr class="light">
          <th>Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Role</th>
          <th style="min-width: 100px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        for ($x = 0; $x < sizeof($rejectedAll); $x++) {
          echo "<tr>";
          echo "  <td>" . $rejectedAll[$x]['first_name'] . " " . $rejectedAll[$x]['middle_name']  . " " . $rejectedAll[$x]['last_name']  . "</td>";
          echo "  <td>" . $rejectedAll[$x]['contact_number'] . "</td>";
          echo "  <td>" . $rejectedAll[$x]['email_address'] . "</td>";

          switch ($rejectedAll[$x]['role']) {
            case '1':
              $rejRole = "Alumni";
              break;
            case '2':
              $rejRole = "Employer";
              break;
            case '3':
              $rejRole = "Faculty";
              break;
            default:
              $rejRole = "Admin";
              break;
          }

          echo "  <td>" . $rejRole . "</td>";
          echo "  <td>";
          echo "    <div class='flex align-items-center list-user-action'>";
          echo "      <!-- Edit Button -->";
          echo "      <a class='btn btn-sm btn-icon' data-bs-toggle='modal' data-bs-target='#myModal" . $x . "rejected' data-bs-placement='top' title='Add' href='#'>";
          echo "        <div class='bd-example'>";
          echo "          <button type='button' class='btn btn-success btn-sm'>View</button>";
          echo "        </div>";
          echo "      </a>";
          echo "    </div>";
          echo "  </td>";
          echo "</tr>";
        ?>

          <div class="modal fade" id="myModal<?php echo $x; ?>rejected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Validate <?= $rejRole; ?> Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 20px; color:black">
                  <div class="alumni-details">
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>First Name:</strong></div>
                      <div class="col-md-8"><?php echo $rejectedAll[$x]['first_name']; ?></div>
                      <div class="col-md-4"><strong>Middle Name:</strong></div>
                      <div class="col-md-8"><?php echo $rejectedAll[$x]['middle_name']; ?></div>
                      <div class="col-md-4"><strong>Last Name:</strong></div>
                      <div class="col-md-8"><?php echo $rejectedAll[$x]['last_name']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Contact #:</strong></div>
                      <div class="col-md-8"><?php echo  $rejectedAll[$x]['contact_number']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Email:</strong></div>
                      <div class="col-md-8"><?php echo $rejectedAll[$x]['email_address']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Address:</strong></div>
                      <div class="col-md-8"><?php echo $rejectedAll[$x]['street_add'] . ", " . $rejectedAll[$x]['barangay'] . ", " . $rejectedAll[$x]['city'] . ", " . $rejectedAll[$x]['province']; ?></div>
                    </div>

                    <?php if ($rejectedAll[$x]['role'] == 1) {
                      bdump($rejectedAlumni);
                      foreach ($rejectedAlumni as $rejectedAlumniInstance) {
                        if ($rejectedAlumniInstance['user_id_alias'] == $rejectedAll[$x]['user_id']) {
                          $rejAlumni = $rejectedAlumniInstance;
                          break;
                        }
                      }

                      $camp0 = $rejAlumni['campusName'];
                      $course0 = $rejAlumni['acronym'];
                      $major0 = $rejAlumni['majorName'];
                    ?>

                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Year Started:</strong></div>
                        <div class="col-md-8"><?php echo $rejAlumni['year_started']; ?></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Year Graduated:</strong></div>
                        <div class="col-md-8"><?php echo $rejAlumni['year_graduated']; ?></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Campus:</strong></div>
                        <div class="col-md-8"><?php echo $camp0; ?></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Course:</strong></div>
                        <div class="col-md-8"><?php echo $course0; ?></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Major:</strong></div>
                        <div class="col-md-8"><?php echo $major0;; ?></div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-4"><strong>Alumni Number:</strong></div>
                        <div class="col-md-8"><?php echo $rejAlumni['studnum']; ?></div>
                      </div>

                    <?php } else if ($rejectedAll[$x]['role'] == 2) {
                      $rejEmp =  $func->select_one('employer_users', array('user_id', '=', $rejectedAll[$x]['user_id']));
                      $company = $func->select_one('companies', array('id', '=', $rejEmp[0]['company_id']));
                      $comp0 = $company[0]['name'];
                      $compSite0 = $company[0]['website'];
                      if ($company[0]['region'] == '') {
                        $compAdd0 = " ";
                      } else {
                        $compAdd0 = $company[0]['street_add'] . ", " . $company[0]['barangay'] . ", " . $company[0]['city'] . ", " . $company[0]['province'];
                      }
                    ?>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Position:</strong></div>
                        <div class="col-md-8"><?php echo $rejEmp[0]['company_position']; ?></div>
                      </div>
                      <div class="row mb-2">

                        <div class="col-md-4"><strong>Employer ID:</strong></div>
                        <div class="col-md-8"><?php echo $rejEmp[0]['employer_num']; ?></div>
                      </div>


                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Company Name:</strong></div>

                        <div class="col-md-8"><?php echo $comp0; ?></div>
                      </div>

                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Company Address:</strong></div>

                        <div class="col-md-8"><?php echo $compAdd0; ?></div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Company Website:</strong></div>
                        <div class="col-md-8"><?php echo $compSite0; ?></div>

                      </div>
                    <?php } else if ($rejectedAll[$x]['role'] == 3) {

                      $rejFac =  $func->select_one('faculty', array('user_id', '=', $rejectedAll[$x]['user_id']));
                      $campus = $func->select_one('campuses', array('campusID', '=', $rejFac[0]['campus_id']));
                      $camp0 = $campus[0]['campusName'];

                      $acadrank = $func->select_one('faculty_rankings', array('id', '=', $rejFac[0]['acadrank_id']));
                      $acadrank0 = $acadrank[0]['description'];


                    ?>

                      <div class="row mb-2">
                        <div class="col-md-4"><strong>Academic Rank:</strong></div>
                        <div class="col-md-8"><?php echo $acadrank0; ?></div>
                      </div>
                      <div class="row mb-2">

                        <div class="col-md-4"><strong>Campus:</strong></div>
                        <div class="col-md-8"><?php echo $camp0; ?></div>
                      </div>
                      <div class="row mb-2">

                        <div class="col-md-4"><strong>Employee ID:</strong></div>
                        <div class="col-md-8"><?php echo $rejFac[0]['employee_num']; ?></div>
                      </div>


                    <?php  } ?>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Reason for Declining:</strong></div>
                    <div class="col-md-8"><?php echo $rejReason0; ?></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success recButton" data-bs-dismiss="modal" data-id="<?php echo $rejectedAll[$x]['user_id']; ?>">Reconsider</button>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
