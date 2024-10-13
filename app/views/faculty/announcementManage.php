<?php

//$dataTesting = $func->selectallorderby('announcements', 'announcement_date', 'DESC');

if (isset($_POST['editAnnouncementBtn'])) {
  $title = $strip->strip($_POST['announcement-title']);
  $body = $strip->strip($_POST['announcement-details']);

  $updateAnnouncement = $func->update('announcements', 'announcement_id', $_POST['editAnnouncementBtn'], array(
    'announcement_title' => $title,
    'announcement_body' => $body,
  ));

  header("location: announcement.php");
}
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div class="header-title">
            <h4 class="card-title">Annnouncement</h4>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="table-responsive ">
            <table id="user-list-table " class="table table-hover" role="grid" data-bs-toggle="data-table">
              <thead>
                <tr class="ligth">
                  <th>Title</th>
                  <th>Author</th>
                  <th style="min-width: 100px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $x = 0;
                foreach ($announcementData as $announcementDataInstance) {
                ?>
                  <tr>
                    <td><?php echo $announcementDataInstance['announcement_title'] ?></td>
                    <td><?php echo $authorDataList[$announcementDataInstance['announcement_author']] ?></td>
                    <td>
                      <div class="flex align-items-center list-user-action">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?php echo $x ?>">
                          Edit
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modal<?php echo $x ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="<?= Flight::request()->base ?>/dashboard/faculty/announcementEdit" class="glassmorphism-form">
                                  <div class="mb-3">
                                    <label for="announcement-title" class="form-label">Announcement Title</label>
                                    <input type="text" class="form-control" id="announcement-title" name="announcement_title" value="<?php echo $announcementDataInstance['announcement_title'] ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="announcement-details" class="form-label">Details</label>
                                    <textarea class="form-control" id="announcement-details" name="announcement_details" required rows="10"><?php echo $announcementDataInstance['announcement_body'] ?></textarea>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="editAnnouncementBtn" value="<?php echo $announcementDataInstance['announcement_id'] ?>">Save changes</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?php echo $x ?>Delete">
                          Delete
                        </button>
                        <div class="modal fade" id="modal<?php echo $x ?>Delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <p>Are you sure you want to delete the following announcement?</p>
                                <h6><?= $announcementDataInstance['announcement_title'] ?></h6>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form method="POST" action="<?= Flight::request()->base ?>/dashboard/faculty/deleteAnnouncement">
                                  <button type="submit" class="btn btn-danger" name="deleteAnnouncementBtn" value="<?php echo $announcementDataInstance['announcement_id'] ?>">Delete Announcement</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php
                  $x++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
