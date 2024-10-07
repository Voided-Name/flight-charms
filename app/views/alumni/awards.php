<?php
bdump($_SESSION['awardAdded']);
if (isset($_POST['addAward'])) {
  /**
   * @var strip $strip
   */
  /**
   * @var func $func
   */
  $name = $strip->strip($_POST['award-name']);
  $date = $strip->strip($_POST['award-date']);
  $institution = $strip->strip($_POST['award-institution']);
  $description = $strip->strip($_POST['award-description']);

  $addAwardFunc = $func->insert('alumni_awards', array(
    'alumni_userID' => $_SESSION['userid'],
    'award_name' => $name,
    'award_date' => $date,
    'award_description' => $description,
    'given_by' => $institution,
  ));
}

if (isset($_POST['editAward'])) {
  $name = $strip->strip($_POST['award-name']);
  $date = $strip->strip($_POST['award-date']);
  $institution = $strip->strip($_POST['award-institution']);
  $description = $strip->strip($_POST['award-description']);

  $editAwardFunc = $func->update('alumni_awards', 'id', $_POST['editAward'], array(
    'alumni_userID' => $_SESSION['userid'],
    'award_name' => $name,
    'award_date' => $date,
    'award_description' => $description,
    'given_by' => $institution,
  ));
}

if (isset($_POST['deleteAward'])) {
  $deleteAwardFunc = $func->delete('alumni_awards', array('id', '=', $_POST['deleteAward']));
}
?>

<div class="conatiner-fluid content-inner mt-n5 py-0">
  <?php
  ?>
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">Manage Awards</h4>
            </div>
            <div class="">
              <a href="#" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="btn-inner">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                  </svg>
                </i>
                <span>Add New Award</span>
              </a>
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Add Award</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="addAward">
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="awardName" class="form-label">Name</label>
                          <input type="text" class="form-control" name="awardName" id="awardName" placeholder="Award Name" required>
                          <label for="award-date" class="form-label">Award Date</label>
                          <input type="date" class="form-control" name="awardDate" id="awardDate" required>
                          <label for="award-institution" class="form-label">Institution</label>
                          <input type="text" class="form-control" name="awardInstitution" id="awardInstitution" placeholder="" required>
                          <label for="award-description" class="form-label">Description</label>
                          <input type="textarea" class="form-control" name="awardDescription" id="awardDescription" required>
                        </div>
                        <div class="text-start">
                          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="addAward">Save</button>
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
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
                  <th>Name</th>
                  <th>Date</th>
                  <th>Institution</th>
                  <th style="min-width: 90px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?= $rows ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  <?php if (isset($_SESSION['awardDeleted'])) {
    if ($_SESSION['awardDeleted']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Deleted',
        text: 'Award Successfully Deleted!'
      })
  <?php $_SESSION['awardDeleted'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['awardNotDeleted'])) {
    if ($_SESSION['awardNotDeleted']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Deleted',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['awardNotDeleted'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['awardEdited'])) {
    if ($_SESSION['awardEdited']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Updated',
        text: 'Award Successfully Updated!'
      })
  <?php $_SESSION['awardEdited'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['awardNotEdited'])) {
    if ($_SESSION['awardNotEdited']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Edited',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['awardNotEdited'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['awardAdded'])) {
    if ($_SESSION['awardAdded']) { ?>
      Swal.fire({
        icon: 'success',
        title: 'Added',
        text: 'Award Successfully Added!'
      })
  <?php $_SESSION['awardAdded'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['awardNotAdded'])) {
    if ($_SESSION['awardNotAdded']) { ?>
      Swal.fire({
        icon: 'error',
        title: 'Not Added',
        text: 'Something went wrong!'
      })
  <?php $_SESSION['awardNotAdded'] = false;
    }
  } ?>
  async function showDeleteAlert(event) {
    Swal.fire({
      title: 'Deleted!',
      text: 'The job is successfully deleted.',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then((result) => {
      deleteAward(event.target.value);
      if (result.value) {
        location.replace("awards.php");
      }
    });
  }

  async function deleteAward(index) {
    console.log("Index: " + index);
    let formData = new FormData();
    formData.append("delete", index);

    await fetch("deleteAward.php", {
        method: 'POST',
        body: formData,
        headers: {},
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
      }).catch(error => console.error("Error: ", error));
  }

  function showEditAlert() {
    Swal.fire({
      title: 'Edited!',
      text: 'The job is successfully edited.',
      icon: 'success',
      showConfirmButton: false
    });
  }

  function showAddAlert() {
    Swal.fire({
      title: 'Added!',
      text: 'The job is successfully added.',
      icon: 'success',
      showConfirmButton: false
    });
  }

  <?php
  //if ($addAwardFunc) {
  ?>
  //showAddAlert();
  <?php
  //}
  ?>

  <?php
  //if ($editAwardFunc) {
  ?>
  //showEditAlert();
  <?php
  //}
  ?>

  <?php
  //if ($deleteAwardFunc) {
  ?>
  //showDeleteAward();
  <?php
  //}
  ?>
</script>

</body>

</html>
