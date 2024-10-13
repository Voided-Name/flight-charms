<?php


if (isset($_POST['postBtn'])) {
  $title = $strip->strip($_POST['announcement-title']);
  $details = $strip->strip($_POST['announcement-details']);

  $insertAnnouncement = $func->insert('announcements', array(
    'announcement_title' => $title,
    'announcement_body' => $details,
    'announcement_date' => date('Y-m-d H:i:s'),
  ));

  $_SESSION['announcementSuccess'] = $insertAnnouncement;

  header("location: post-announcement.php");
}

?>
<div class="card">
  <div class="container p-5">
    <section id="feedback" class="pt-3 col-12">
      <h1>Announcement</h1>
      <form method="POST" action="postAnnouncementMethod" class="glassmorphism-form">
        <div class="mb-3">
          <label for="announcement-title" class="form-label">Announcement Title</label>
          <input type="text" class="form-control" id="announcement-title" name="announcement_title" required>
        </div>
        <div class="mb-3">
          <label for="announcement-details" class="form-label">Details</label>
          <textarea class="form-control" id="announcement-details" name="announcement_details" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="postBtn">Post Annnouncement</button>
      </form>
    </section>
  </div>
</div>

</body>

</html>
