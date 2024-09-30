<?php bdump($alumniUnverified) ?>
<div class="card-header d-flex justify-content-between">
  <div class="header-title">
    <h4 class="card-title">Validate Alumni Account</h4>
    <p><?php //var_dump($alumniUnverified)
        ?></p>
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
          <th>Campus</th>
          <th>Year Graduated</th>
          <th>Course</th>
          <th style="min-width: 100px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($alumniUnverified as $alumni): ?>
          <?php bdump($alumni) ?>
          <tr>
            <td><?= $alumni['first_name'] . ' ' . $alumni['middle_name'] . ' ' . $alumni['last_name']; ?></td>
            <td><?= $alumni['contact_number']; ?></td>
            <td><?= $alumni['email_address']; ?></td>
            <td><?= $alumni['campusName']; ?></td>
            <td><?= !empty($alumni['year_graduated']) ? $alumni['year_graduated'] : 'Not Filled Yet'; ?></td>
            <td><?= !empty($alumni['acronym']) ? $alumni['acronym'] : 'Not Filled Yet'; ?></td>
            <td>
              <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?= $alumni['user_id']; ?>">View</a>
              <div class="modal fade" id="myModal<?= $alumni['user_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Validate Alumni Account</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: 20px; color:black">
                      <div class="alumni-details">

                        <div class="row mb-2">
                          <div class="col-md-4"><strong>First Name:</strong></div>
                          <div class="col-md-8"><?= $alumni['first_name']; ?></div>
                          <div class="col-md-4"><strong>Middle Name:</strong></div>
                          <div class="col-md-8"><?= $alumni['middle_name'];  ?></div>
                          <div class="col-md-4"><strong>Last Name:</strong></div>
                          <div class="col-md-8"><?= $alumni['last_name']; ?></div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Contact:</strong></div>
                          <div class="col-md-8"><?= $alumni['contact_number']; ?></div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Email:</strong></div>
                          <div class="col-md-8"><?= $alumni['email_address']; ?></div>

                        </div>
                        <div class="row mb-2">

                          <div class="col-md-4"><strong>Address:</strong></div>
                          <div class="col-md-8"><?= $alumni['street_add'] . ", " . $alumni['barangay'] . ", " . $alumni['city'] . ", " . $alumni['province']; ?></div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Year Started:</strong></div>
                          <div class="col-md-8">
                            <?php
                            if (!empty($alumni['year_started'])) {
                              echo $alumni['year_started'];
                            } else {
                              echo "Not Filled Yet";
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Year Graduated:</strong></div>
                          <div class="col-md-8">
                            <?php
                            if (!empty($alumni['year_graduated'])) {
                              echo $alumni['year_graduated'];
                            } else {
                              echo "Not Filled Yet";
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Campus:</strong></div>
                          <div class="col-md-8">
                            <?php
                            if (!empty($alumni['campusName'])) {
                              echo $alumni['campusName'];
                            } else {
                              echo "Not Filled Yet";
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Course:</strong></div>
                          <div class="col-md-8">
                            <?php
                            if (!empty($alumni['courseName'])) {
                              echo $alumni['courseName'];
                            } else {
                              echo "Not Filled Yet";
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-4"><strong>Major:</strong></div>
                          <div class="col-md-8">
                            <?php
                            if ($alumni['majorName'] || $alumni['courseName']) {
                              echo $alumni['majorName'];
                            } else {
                              echo "Not Filled Yet";
                            }
                            ?>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col-md-4"><strong>Alumni Number:</strong></div>
                          <div class="col-md-8"><?php echo $alumni['studnum']; ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success accButton" data-id="<?php echo $alumni['user_id_alias']; ?>" id="acceptButton">Approve</button>
                      <button type="button" class="btn btn-danger delButton" data-bs-dismiss="modal" data-id="<?php echo $alumni['user_id_alias']; ?>">Decline</button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
