<?php

if (isset($_POST['viewBtnVal'])) {
  $_SESSION['viewPostID'] = $_POST['viewBtnVal'];

  header("Location: viewApps.php");
  exit();
}

if (isset($_POST['employApplicant'])) {
  $alumniId = $strip->strip($_POST['alumniId']);
  $postId = $strip->strip($_POST['postId']);
  $status = $strip->strip($_POST['statusId']);

  $statusId = $func->selectall_where2('alumni_employment_status', array('status_post_id', '=', $postId), array('status_alumni_id', '=', $alumniId));

  $func->update('alumni_employment_status', 'status_id', $statusId[0]['status_id'], array(
    'status' => 1,
  ));
  header("location: viewApps.php");
} else if (isset($_POST['rejectApplicant'])) {
  $alumniId = $strip->strip($_POST['alumniId']);
  $postId = $strip->strip($_POST['postId']);
  $status = $strip->strip($_POST['statusId']);

  $statusId = $func->selectall_where2('alumni_employment_status', array('status_post_id', '=', $postId), array('status_alumni_id', '=', $alumniId));

  $func->update('alumni_employment_status', 'status_id', $statusId[0]['status_id'], array(
    'status' => 2,
  ));
  header("location: viewApps.php");
}

if (isset($_SESSION['viewPostID'])) {
  $appsData = $func->selectall_where('applications', array(
    'application_post_id',
    '=',
    $_SESSION['viewPostID']
  ));
} else {
  header("Location: job-vacancies.php");
}


?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">View Applications</h4>
            </div>
          </div>
          <div class="card-body px-0">
            <?php //var_dump($appsData) 
            ?>
            <div class="table-responsive">
              <table id="apps-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                <thead>
                  <tr class="ligth">
                    <th>Name</th>
                    <th>Program</th>
                    <th>Action</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $index = 0;
                  foreach ($appsData as $appsDataInstance) {
                    bdump($appsInformation);
                    $db = Flight::db();
                    //$stmt = $db->prepare('SELECT * FROM userdetails WHERE user_id = :application_alumni_id');
                    //$alumniInstance = $func->select_one('userdetails', array('user_id', '=', $appsDataInstance['application_alumni_id']));
                    //$name = $alumniInstance[0]['last_name'] . ', ' . $alumniInstance[0]['first_name'] . ' ' . $alumniInstance[0]['middle_name'];
                    //$courseID = $func->select_one('alumni_graduated_course', array('user_id', '=', $appsDataInstance['application_alumni_id']));
                    //$course = $func->select_one('courses', array('courseID', '=', $courseID[0]['course_id']));
                    //$statusId = $func->selectall_where2('alumni_employment_status', array('status_post_id', '=', $appsDataInstance['application_post_id']), array('status_alumni_id', '=', $appsDataInstance['application_alumni_id']));
                  ?>
                    <tr>
                      <td><?php echo $appsInformation[$index]['name'] ?></td>
                      <td><?php echo $appsInformation[$index]['appsInformationCourse']['courseName'] ?></td>
                      <td>
                        <div class="d-flex align-items-center list-user-action">
                          <form method="GET" action="<?= Flight::request()->base ?>/dashboard/employer/viewApps/viewFile" class="me-2">
                            <button type="submit" class="btn btn-primary" value="<?php echo $appsDataInstance['file_name'] ?>" name="viewResumeBtn">View File</button>
                          </form>
                          <form method="POST">
                            <input type="hidden" name="postId" value="<?php echo $appsDataInstance['application_post_id'] ?>">
                            <input type="hidden" name="alumniId" value="<?php echo $appsDataInstance['application_alumni_id'] ?>">
                            <button type="submit" class="btn btn-success me-2" value="<?php echo $appsDataInstance['application_alumni_id'] ?>" name="employApplicant">Employ</button>
                          </form>
                          <form method="POST">
                            <input type="hidden" name="postId" value="<?php echo $appsDataInstance['application_post_id'] ?>">
                            <input type="hidden" name="alumniId" value="<?php echo $appsDataInstance['application_alumni_id'] ?>">
                            <button type="submit" class="btn btn-danger me-2" value="<?php echo $appsDataInstance['application_alumni_id'] ?>" name="rejectApplicant">Reject</button>
                          </form>
                          <form method="POST" action="viewProfile.php">
                            <button type="submit" class="btn btn-info" value="<?php echo $appsDataInstance['application_alumni_id'] ?>" name="viewProfileBtn">View Profile</button>
                          </form>
                        </div>
                      </td>
                      <td>
                        <p class="<?php switch ($appsInformation[$index]['appsInformationStatus']['employment_status']) {
                                    case 0:
                                      echo "bg-dark";
                                      break;
                                    case 1:
                                      echo "bg-success";
                                      break;
                                    case 2:
                                      echo "bg-danger";
                                      break;

                                    default:
                                      echo "bg-dark";
                                      break;
                                  } ?> text-white p-1 text-center rounded">
                          <?php
                          switch ($appsInformation[$index]['appsInformationStatus']['employment_status']) {
                            case 0:
                              echo "Pending";
                              break;
                            case 1:
                              echo "Employed";
                              break;
                            case 2:
                              echo "Rejected";
                              break;

                            default:
                              echo "Pending";
                              break;
                          } ?>
                        </p>
                      </td>
                    </tr>
                  <?php
                    $index++;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
</body>

</html>
