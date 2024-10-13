<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CICT CHARM</title>

  <link rel="shortcut icon" href="<?= Flight::request()->base ?>/assets/img/favicon.ico">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/core/libs.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1_vendor/aos/dist/aos.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/hope-ui.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/custom.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/dark.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/rtl.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/customizer.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/mycss.css">
  <link rel="preconnect" href="https://rsms.me/">
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
</head>

<body class="  ">
  <!-- loader Start -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>
  <!-- Sidebar Menu End -->
  </aside>
  <main class="main-content">
    <div class="conatiner-fluid content-inner mt-3 py-0">
      <div class="container">
        <h1 class=" text-center" style="font-family: Georgia, 'Times New Roman', Times, serif;">Announcements</h1>
        <hr style="border: 2px solid black;">
        <?php
        foreach ($announcementData as $announcementInstance) {
        ?>
          <div class="container m-3 p-3 shadow-lg">
            <h2><?php echo $announcementInstance['announcement_title'] ?></h2>
            <p class="ms-3"><?php echo nl2br($announcementInstance['announcement_body']) ?></p>
            <p><?php echo (new DateTime($announcementInstance['announcement_date']))->format('F j, Y g:i A') ?></p>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </main>

  <script src="<?= Flight::request()->base ?>/assets/js/core/libs.min.js"></script>
  <!-- External Library Bundle Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/core/external.min.js"></script>
  <!-- Widgetchart Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/charts/widgetcharts.js"></script>
  <!-- mapchart Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/charts/vectore-chart.js"></script>
  <script src="<?= Flight::request()->base ?>/assets/js/charts/dashboard.js"></script>
  <!-- fslightbox Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/plugins/fslightbox.js"></script>
  <!-- Settings Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/plugins/setting.js"></script>
  <!-- Slider-tab Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/plugins/slider-tabs.js"></script>
  <!-- Form Wizard Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/plugins/form-wizard.js"></script>
  <!-- AOS Animation Plugin-->
  <script src="<?= Flight::request()->base ?>/assets/css/theme_1_vendor/aos/dist/aos.js"></script>
  <!-- App Script -->
  <script src="<?= Flight::request()->base ?>/assets/js/hope-ui.js" defer></script>
</body>

</html>
