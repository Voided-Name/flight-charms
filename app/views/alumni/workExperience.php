<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">Manage Experience</h4>
            </div>
            <div class="">
              <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="btn-inner">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                </i>
                <span>Add Work Experience</span>
              </a>
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Add Experience</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="addWorkExp">
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="institutionName" class="form-label">Institution/Company Name</label>
                          <input type="text" class="form-control" id="institutionName" name="institutionName" placeholder="" required>
                          <label for="position" class="form-label">Position</label>
                          <input type="text" class="form-control" id="position" name='position' placeholder="" required>
                          <label for="startDate" class="form-label">Date Start</label>
                          <input type="date" class="form-control" id="startDate" name="startDate" required>
                          <label for="endDate" class="form-label">Date End</label>
                          <input type="date" class="form-control" id="endDate" name="endDate" required>
                          <label for="workExpDescription" class="form-label">Description</label>
                          <textarea class="form-control" id="workExpDescription" name="workExpDescription" required></textarea>
                        </div>
                        <div class="text-start">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="addExperience" value="<?php $_SESSION['userid'] ?>">Add</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="table-responsive">
            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
              <thead>
                <tr class="ligth">
                  <th>Institution Name</th>
                  <th>Position</th>
                  <th>Date Start</th>
                  <th>Date End</th>
                  <th style="min-width: 90px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?= $workExperienceRows ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  <?php if (isset($_SESSION['workExpDeleted'])) {
    if ($_SESSION['workExpDeleted']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Deleted',
        text: 'Work Experience Successfully Deleted!'
      })
  <?php $_SESSION['workExpDeleted'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['workExpNotDeleted'])) {
    if ($_SESSION['workExpNotDeleted']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Deleted',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['workExpNotDeleted'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['workExpEdited'])) {
    if ($_SESSION['workExpEdited']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Updated',
        text: 'Work Experience Successfully Updated!'
      })
  <?php $_SESSION['workExpEdited'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['workExpNotEdited'])) {
    if ($_SESSION['workExpNotEdited']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Edited',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['workExpNotEdited'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['workExpAdded'])) {
    if ($_SESSION['workExpAdded']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Added',
        text: 'Work Experience Successfully Added!'
      })
  <?php $_SESSION['workExpAdded'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['workExpNotAdded'])) {
    if ($_SESSION['workExpNotAdded']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Added',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['workExpNotAdded'] = false;
    }
  } ?>
</script>

</body>

</html>
