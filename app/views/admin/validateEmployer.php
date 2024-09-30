<?bdump($employerUnverified)?>
<div class="card-header d-flex justify-content-between">
  <div class="header-title">
    <h4 class="card-title">Validate Employer Account</h4>
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

          <th>Company Name</th>

          <!-- <th>Position</th> -->
          <th style="min-width: 100px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($employerUnverified) {
          for ($x = 0; $x < count($employerUnverified); $x++) {

            echo "<tr>";
            echo "  <td>" . $employerUnverified[$x]['first_name'] . " " . $employerUnverified[$x]['middle_name']  . " " . $employerUnverified[$x]['last_name']  . "</td>";

            echo "  <td>" . $employerUnverified[$x]['contact_number'] . "</td>";
            echo "  <td>" . $employerUnverified[$x]['email_address'] . "</td>";

            /*$company = $func->select_one('companies', array('id', '=', $employerUnverified[$x]['company_id']));*/
            /*$comp0 = $company[0]['name'];*/
            /*$compSite0 = $company[0]['website'];*/

            /*if ($company[0]['region'] == '') {*/
            /*  $compAdd0 = " ";*/
            /*} else {*/
            /*  $compAdd0 = $company[0]['street_add'] . ", " . $company[0]['barangay'] . ", " . $company[0]['city'] . ", " . $company[0]['province'];*/
            /*}*/

            echo "  <td>" . $employerUnverified[$x]['company_name'] . "</td>";
            // echo "  <td>" . $employerUnverified[$x]['company_position'] . "</td>";
            echo "  <td>";
            echo "    <div class='flex align-items-center list-user-action'>";

            echo "      <button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#employer$x'>View</button>";
            echo "    </div>";
            echo "  </td>";
            echo "</tr>";
        ?>
            <!-- Modal -->
            <div class="modal fade" id="employer<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo $x; ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel<?php echo $x; ?>">Validate Employer Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" style="font-size: 20px; color:black">
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>First Name:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['first_name']; ?></div>
                      <div class="col-md-4"><strong>Middle Name:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['middle_name'];  ?></div>
                      <div class="col-md-4"><strong>Last Name:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['last_name']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Contact #:</strong></div>
                      <div class="col-md-8"><?php echo  $employerUnverified[$x]['contact_number']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Email:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['email_address']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Address:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['street_add'] . ", " . $employerUnverified[$x]['barangay'] . ", " . $employerUnverified[$x]['city'] . ", " . $employerUnverified[$x]['province']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Position:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['company_position']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Employer ID:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['employer_num']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Company Name:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['company_name']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Company Address:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['company_address']; ?></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-4"><strong>Company Website:</strong></div>
                      <div class="col-md-8"><?php echo $employerUnverified[$x]['company_website']; ?></div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success accButton" data-id="<?php echo $employerUnverified[$x]['user_id_alias']; ?>" id="acceptButton">Approve</button>
                    <button type="button" class="btn btn-danger delButton" data-bs-dismiss="modal" data-id="<?php echo $employerUnverified[$x]['user_id_alias']; ?>">Decline</button>
                  </div>
                </div>
              </div>
            </div>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
