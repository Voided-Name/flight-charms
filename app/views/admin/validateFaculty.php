<?php bdump($facultyUnverified) ?>
<div class="card-header d-flex justify-content-between">
  <div class="header-title">
    <h4 class="card-title">Validate Faculty Account</h4>
  </div>
</div>
<div class="card-body px-0">
  <div class="table-responsive">
    <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
      <thead>
        <tr class="light">
          <th>Faculty Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Campus</th>
          <th>Academic Rank</th>
          <th style="min-width: 100px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($x = 0; $x < count($facultyUnverified); $x++) {

          /*$campus = $func->select_one('campuses', array('campusID', '=', $facultyUnverified[$x]['campus_id']));*/
          /*$camp0 = $campus[0]['campusName'];*/
          /**/
          /*$acadrank = $func->select_one('faculty_rankings', array('id', '=', $facultyUnverified[$x]['acadrank_id']));*/
          /*$acadrank0 = $acadrank[0]['description'];*/

          echo "<tr>";
          echo "  <td>" . $facultyUnverified[$x]['first_name'] . " " . $facultyUnverified[$x]['middle_name']  . " " . $facultyUnverified[$x]['last_name']  . "</td>";
          echo "  <td>" . $facultyUnverified[$x]['contact_number'] . "</td>";
          echo "  <td>" . $facultyUnverified[$x]['email_address'] . "</td>";
          echo "  <td>" . $facultyUnverified[$x]['campusName'] . "</td>";
          echo "  <td>" . $facultyUnverified[$x]['f_rank_description'] . "</td>";
          echo "  <td>";
          echo "    <div class='flex align-items-center list-user-action'>";
          echo "      <button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#faculty$x'>View</button>";
          echo "    </div>";
          echo "  </td>";
          echo "</tr>";
        ?>
          <div class="modal fade" id="faculty<?php echo $x; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo $x; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel<?php echo $x; ?>">Validate Faculty Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 20px; color:black">
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>First Name:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['first_name']; ?></div>
                    <div class="col-md-4"><strong>Middle Name:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['middle_name'];  ?></div>
                    <div class="col-md-4"><strong>Last Name:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['last_name']; ?></div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Contact #:</strong></div>
                    <div class="col-md-8"><?php echo  $facultyUnverified[$x]['contact_number']; ?></div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['email_address']; ?></div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Address:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['street_add'] . ", " . $facultyUnverified[$x]['barangay'] . ", " . $facultyUnverified[$x]['city'] . ", " . $facultyUnverified[$x]['province']; ?></div>
                  </div>

                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Academic Rank:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['f_rank_description']; ?></div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Campus:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['campusName']; ?></div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-md-4"><strong>Employee ID:</strong></div>
                    <div class="col-md-8"><?php echo $facultyUnverified[$x]['employee_num']; ?></div>
                  </div>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success accButton" data-id="<?php echo $facultyUnverified[$x]['user_id_alias']; ?>" id="acceptButton">Approve</button>
                  <button type="button" class="btn btn-danger delButton" data-bs-dismiss="modal" data-id="<?php echo $facultyUnverified[$x]['user_id_alias']; ?>">Decline</button>
                </div>
              </div>
            </div>
          </div>

        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
