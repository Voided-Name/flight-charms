<?php
$date = new DateTime($profileData['birth_date']);
?>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="row">
        <div class="col-md-12">
          <div class="card" data-aos="fade-up" data-aos-delay="800">
            <div class="container p-5">
              <hr>
              <h1>Profile</h1>
              <h5>Name: <?php echo $profileData['first_name'] . ' ' . $profileData['middle_name'] . ' ' . $profileData['last_name'] ?></h5>
              <h5>Birth Date: <?php echo $date->format('F d, Y'); ?></h5>
              <h5>Address: <?php echo $profileData['province'] . ', ' . $profileData['city'] . ', ' . $profileData['barangay'] . ', ' . $profileData['street_add'] ?></h5>
              <hr>
              <h1>NEUST Course</h1>
              <h5>Student Number: <?php echo $profileData['studnum'] ?> </h5>
              <h5>Year Enrolled: <?php echo $profileData['year_started'] ?></h5>
              <h5>Year Graduated: <?php echo $profileData['year_graduated'] ?></h5>
              <h5>Campus: <?php echo $profileData['campusName'] ?></h5>
              <h5>Course: <?php echo $profileData['courseName'] ?></h5>
              <hr>
              <h1>Awards</h1>
              <?php foreach ($profileAwards as $profileAward) {
                $date = new DateTime($profileAward['award_date']) ?>
                <h5>Award: <?php echo $profileAward['award_name'] ?></h5>
                <h5>Date: <?php echo $date->format('F d, Y') ?></h5>
                <h5>From: <?php echo $profileAward['given_by'] ?></h5>
                <p><?php echo $profileAward['award_description'] ?></p>
                <?
              }
              ?>
                <hr>
                <h1>Work Experiences</h1>
                <?php foreach ($profileWorkExp as $profileWorkExpInstance) {
                  $dateStarted = new DateTime($profileWorkExpInstance['date_started']);
                  $dateEnded = new DateTime($profileWorkExpInstance['date_end']);
                ?>
                  <h5>Position: <?php echo $profileWorkExpInstance['work_position'] ?></h5>
                  <h5>Company: <?php echo $profileWorkExpInstance['work_name'] ?></h5>
                  <h5>Started: <?php echo $dateStarted->format('F d, Y') ?></h5>
                  <h5>Ended: <?php echo $dateEnded->format('F d, Y') ?></h5>
                  <p><?php echo $profileWorkExpInstance['work_description'] ?></>
                <?php } ?>
                <hr>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
