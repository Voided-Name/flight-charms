<?php

$x = 0;
foreach ($alumniWorkData as $alumniWorkInstance) {
?>
  <tr>
    <td><?php echo $alumniWorkInstance['work_name'] ?></td>
    <td><?php echo $alumniWorkInstance['work_position'] ?></td>
    <td><?php echo date("F j, Y", strtotime($alumniWorkInstance['date_started'])); ?></td>
    <td><?php echo date("F j, Y", strtotime($alumniWorkInstance['date_end'])); ?></td>
    <td>
      <div class="flex align-items-center list-user-action">
        <!-- Edit Button -->
        <a class="btn btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#workEditModal<?php echo $x ?>" data-bs-placement="top" title="Add" href="#">
          <div class="bd-example">
            <button type="button" class="btn btn-success btn-sm">Edit</button>
          </div>
        </a>

        <!-- Modal Structure -->
        <div class="modal fade" id="workEditModal<?php echo $x ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="editWorkExp">
                  <label for="work-name" class="form-label">Institution/Company</label>
                  <input type="text" class="form-control" name="work-name" id="work-name" placeholder="Award Name" value="<?php echo $alumniWorkInstance['work_name'] ?>">
                  <label for="work-position" class="form-label">Position</label>
                  <input type="text" class="form-control" name="work-position" id="work-position" value="<?php echo $alumniWorkInstance['work_position']  ?>">
                  <label for="date-start" class="form-label">Date Started</label>
                  <input type="date" class="form-control" name="date-start" id="date-start" value="<?php echo $alumniWorkInstance['date_started'] ?>">
                  <label for="date-end" class="form-label">Date Ended</label>
                  <input type="date" class="form-control" name="date-end" id="date-end" value="<?php echo  $alumniWorkInstance['date_end'] ?>">
                  <label for="work-description" class="form-label">Description</label>
                  <textarea class="form-control" name="work-description" id="work-description" value=""><?php echo  $alumniWorkInstance['work_description'] ?></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="" value="<?php echo $alumniWorkInstance['work_exp_id'] ?>" name="editWork">Save
                  changes</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <a class="btn btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#workDeleteModal<?php echo $x ?>" data-bs-placement="top" title="Delete" href="#">
          <div class="bd-example">
            <button type="button" class="btn btn-danger btn-sm">Delete</button>
          </div>
        </a>

        <div class="modal fade" id="workDeleteModal<?php echo $x ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  Remove Work Experience?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="deleteWorkExp">
                  <h3>Confirm Work Experience Removal</h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" value="<?php echo $alumniWorkInstance['work_exp_id'] ?>" name="deleteWork">Delete
                  Work Experience</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
  <tr>
  <?php
  $x++;
}
  ?>
