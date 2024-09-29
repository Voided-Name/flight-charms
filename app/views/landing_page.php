<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>CICT CHARM</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--<link rel="manifest" href="site.webmanifest">-->
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

  <!-- CSS here -->
  <?= $stylesheets ?>
  <style>
    .hero-bg {
      background-image: url("assets/img/butterflyEdited.jpg");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    }

    #slide1 {
      background-image: url("assets/img/teamwork.jpg");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    #slide2 {
      background-image: url("assets/img/alumnis.jpg");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    #slide3 {
      background-image: url("assets/img/community.jpg");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .hero-text {
      font-size: 70px;
      color: white;
    }

    .slider-wrapper {
      margin: 1rem;
      position: relative;
      overflow: hidden;
    }

    .slides-container {
      height: calc(50vh - 2rem);
      width: 100%;
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
      overflow: scroll;
      scroll-behavior: smooth;
    }

    .slide {
      width: 100%;
      height: 100%;
      flex: 1 0 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 3rem;
    }

    .slide-arrow {
      position: absolute;
      display: flex;
      justify-items: center;
      align-items: center;
      top: 0;
      bottom: 0;
      margin: auto;
      height: 4rem;
      background-color: white;
      border: none;
      width: 2rem;
      font-size: 3rem;
      padding: 0;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 100ms;
    }

    .slide-arrow:hover,
    .slide-arrow:focus {
      opacity: 0.9;
    }

    #slide-arrow-prev {
      left: 0;
      padding-left: 0.25rem;
      outline: none;
    }

    #slide-arrow-next {
      right: 0;
      padding-left: 0.75rem;
      outline: none;
    }
  </style>
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
  <!-- Preloader end -->
  <?= $header ?>
  <main>

    <div class="slider-area ">
      <div class="single-slider section-overly slider-height2 d-flex align-items-center"
        data-background="assets/img/businessman.jpg">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="hero-cap text-center">
                <h2>Find Your Dream Job Here</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <div class="container">
      <div class="section-tittle section-tittle2">
        <span>What We Do</span>
        <h2>Where talent meets opportunity.</h2>
      </div>
      <div class="support-caption">
        <p class="pera-top">Our platform is designed to streamline the job search and
          hiring process, making it easier than ever to discover and secure the
          perfect match.</p>
        <p>Whether you're an employer looking to attract top talent or a jobseeker
          ready to take the next step in your career, CHARMS is here to
          support your journey. Join our community today and discover the difference
          a dedicated and innovative job platform can make.</p>
        <a href="view/about.html" class="btn post-btn text-center">About Us</a>
      </div>
    </div>

    <div class="container" style="margin-top: 20px;">
      <div class="section-tittle section-tittle2 text-center">
        <h2>Key Objectives</h2>
      </div>
      <div class="container">
        <section class="slider-wrapper">
          <button class="slide-arrow" id="slide-arrow-prev">
            &#8249;
          </button>

          <button class="slide-arrow" id="slide-arrow-next">
            &#8250;
          </button>

          <ul class="slides-container" id="slides-container">
            <li id="slide1" class="slide">Enhance Alumni-Employer Connections</li>
            <li id="slide2" class="slide">Strengthen Alumni Relations</li>
            <li id="slide3" class="slide">Foster a Productive Community</li>
          </ul>
        </section>
      </div>

    </div>

    <div class="container" style="margin-top: 80px;">
      <div class="section-tittle section-tittle2" style="text-align: right;">
        <h2 style="text-align: left;">"</h2>
        <h2>Talent is everywhere, it only needs opportunity</h2>
        <h2>"</h2>
        <p>- Kathrine Switzer</p>
      </div>
    </div>
    <div class="container text-center">
      <a href="<?= Flight::request()->base ?>/login" class="btn post-btn text-center" style="width: 70%">Join Us</a>
    </div>
    <hr>

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

  <script>
    const slidesContainer = document.getElementById("slides-container");
    const slide = document.querySelector(".slide");
    const prevButton = document.getElementById("slide-arrow-prev");
    const nextButton = document.getElementById("slide-arrow-next");
    nextButton.addEventListener("click", () => {
      const slideWidth = slide.clientWidth;
      slidesContainer.scrollLeft += slideWidth;
    });
    prevButton.addEventListener("click", () => {
      const slideWidth = slide.clientWidth;
      slidesContainer.scrollLeft -= slideWidth;
    });
  </script>

</body>

</html>
