<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>CHARMS</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

  <!-- CSS here -->
  <?= $stylesheets ?>
</head>

<body>
  <!-- Preloader Start -->
  <div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
      <div class="preloader-inner position-relative">
        <div class="preloader-circle"></div>
        <div class="preloader-img pere-text">
          <img src="assets/img/logoCharms.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- Preloader Start -->
  <?= $header ?>
  <main>
    <!-- Hero Area Start-->
    <div class="slider-area ">
      <div class="single-slider section-overly slider-height2 d-flex align-items-center"
        data-background="assets/img/bg/about.jpg">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="hero-cap text-center">
                <h2>About us</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Hero Area End -->
    <!-- Support Company Start-->
    <div class="support-company-area fix section-padding2">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-6 col-lg-6">
            <div class="right-caption">
              <!-- Section Tittle -->
              <div class="section-tittle section-tittle2">
                <span>What We Do</span>
                <h2>24k Talented people are getting Jobs</h2>
              </div>
              <div class="support-caption">
                <p class="pera-top">We understand the transformative power of a fulfilling career and
                  the impact of finding the right fit for both employers and jobseekers.</p>
                <p>Founded in 2023, CHARMS emerged from a simple yet powerful idea:
                  to bridge the gap between employers seeking dedicated professionals and individuals
                  eager to advance their careers. With a team of passionate innovators, we have
                  created a dynamic space where opportunity meets potential, helping countless
                  businesses and job seekers achieve their goals.</p>
                <a href="login.php" class="btn post-btn">Post a job</a>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6">
            <div class="support-location-img">
              <img src="assets/img/gallery/support-img.jpg" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Support Company End-->
  </main>
  <footer>
    <div class="footer-bg" style="padding:20px">
      <!-- Footer Start-->
      <div class="container text-center">
        <img src="assets/img/logoCharmsWhite.png" style="width: 50px">
      </div>
    </div>
  </footer>

  <!-- JS here -->
  <?= $scripts ?>
</body>

</html>
