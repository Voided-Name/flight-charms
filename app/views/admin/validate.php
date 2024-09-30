<?php bdump($_SESSION['validated']) ?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <ul class="nav nav-tabs p-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="alumni-tab" data-bs-toggle="tab" data-bs-target="#alumni" type="button" role="tab" aria-controls="alumni" aria-selected="true">Alumni</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="employer-tab" data-bs-toggle="tab" data-bs-target="#employer" type="button" role="tab" aria-controls="employer" aria-selected="false">Employer</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="faculty-tab" data-bs-toggle="tab" data-bs-target="#faculty" type="button" role="tab" aria-controls="faculty" aria-selected="false">Faculty</button>

            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">Rejected</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="alumni" role="tabpanel" aria-labelledby="alumni-tab">
              <?= $validateAlumni  ?>
            </div>

            <div class="tab-pane fade" id="employer" role="tabpanel" aria-labelledby="employer-tab">
              <?= $validateEmployer ?>
            </div>
            <div class="tab-pane fade" id="faculty" role="tabpanel" aria-labelledby="faculty-tab">
              <?= $validateFaculty ?>
            </div>
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
              <?= $rejected ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if (isset($_SESSION['validated'])) {
    if ($_SESSION['validated'] === TRUE) { ?>
      Swal.fire(
        'Approved!',
        'User account has been approved to the system!',
        'success'
      )
  <?php
      $_SESSION['validated'] = false;
    }
  } ?>

  <?php if (isset($_SESSION['rejected'])) {
    if ($_SESSION['rejected'] === TRUE) { ?>
      Swal.fire(
        'Rejected!',
        'User account has been rejected!',
        'success'
      )
  <?php
      $_SESSION['rejected'] = false;
    }
  } ?>

  document.querySelectorAll('.accButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.dataset.id;
      Swal.fire({
        title: 'Are you sure?',
        text: "You want to approve this action!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
      }).then((result) => {
        if (result.isConfirmed) {
          var form = document.createElement('form');
          form.method = 'POST';
          form.action = 'approve'
          form.style.display = 'none';
          var input = document.createElement('input');
          input.name = 'approve_id';
          input.value = id;
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });

  document.querySelectorAll('.delButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.dataset.id;
      var reason = this.dataset.reason || '';
      Swal.fire({
        title: 'Are you sure?',
        text: "You want to decline this action!",
        input: 'textarea',
        inputPlaceholder: 'Enter your reason here...',
        inputValue: reason,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, decline it!'
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          var form = document.createElement('form');
          form.method = 'POST';
          form.action = 'reject';
          form.style.display = 'none';
          var inputId = document.createElement('input');
          inputId.name = 'delete_id';
          inputId.value = id;
          form.appendChild(inputId);
          var inputReason = document.createElement('input');
          inputReason.name = 'reason';
          inputReason.value = result.value;
          form.appendChild(inputReason);
          var rejectedDate = document.createElement('input');
          rejectedDate.name = 'rejected_date';

          now = new Date();
          formattedDateTime = now.toISOString().slice(0, 19).replace('T', ' ');

          rejectedDate.value = formattedDateTime;
          form.appendChild(rejectedDate);
          document.body.appendChild(form);
          form.submit();
        } else {
          Swal.fire(
            'Cancelled',
            'Your action has not been declined.',

            'error'
          );
        }
      });
    });
  });




  document.querySelectorAll('.recButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.dataset.id;
      var reason = this.dataset.reason || '';


      Swal.fire({
        title: 'Are you sure?',
        text: "You want to Reconsider this acccount!",
        input: 'textarea',
        inputPlaceholder: 'Enter your reason here...',
        inputValue: reason,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reconsider it!'
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          Swal.fire(
            'Reconsider!',
            'The account has been reconsidered.',
            'success'
          ).then(() => {
            var form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';
            var inputId = document.createElement('input');
            inputId.name = 'recon_id';

            inputId.value = id;
            form.appendChild(inputId);
            var inputReason = document.createElement('input');
            inputReason.name = 'reason';
            inputReason.value = result.value;
            form.appendChild(inputReason);
            document.body.appendChild(form);
            form.submit();
          });
        }
      });

    });
  });
</script>
