<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>CICT CHARM </title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">

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
  <!-- Hero Area Start-->
  <main style="min-height:80vh">
    <div class="container text-center">
      <hr>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d246125.2819326004!2d120.81452980198824!3d15.446328847162409!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339727d57ef0edc9%3A0x94e292410c0bdb28!2sNueva%20Ecija%20University%20of%20Science%20and%20Technology%2C%20Sumacab%20Campus!5e0!3m2!1sen!2sph!4v1724380703453!5m2!1sen!2sph"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
      <hr>
    </div>
    <div class="container text-center">
      <div class="row">
        <div class="col-sm">
          <h4>
            Email:
          </h4>
          sample@gmail.com
        </div>
        <div class="col-sm">
          <h4>
            Landline:
          </h4>
          123 456
        </div>
        <div class="col-sm">
          <h4>
            Phone Number:
          </h4>
          +63 918 638 8102
        </div>
      </div>
      <hr>
      <div class="d-flex justify-content-center">
        <div style="padding-right: 20px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook"
            viewBox="0 0 16 16" sytle="pad">
            <path
              d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
          </svg>
        </div>
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-envelope"
            viewBox="0 0 16 16">
            <path
              d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
          </svg>
        </div>
      </div>
    </div>
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
