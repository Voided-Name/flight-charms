<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
//include 'src/init.php';

/**
 * 
 * @var strip $strip
 */
/**
 * 
 * @var res $func
 */
?>
<!doctype html>

<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CHARMS</title>
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    html,
    body {
      height: 100%;
    }

    body {
      background-image: url("assets/img/loginImageBlur.jpg");
      background-size: cover;
    }

    .logForm {
      width: 100%;
    }

    .signLogo {
      max-width: 500px;
    }

    .custom-shape-divider-top-1716877928 {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      line-height: 0;
      z-index: -1;
      transform: rotate(180deg);
    }

    .custom-shape-divider-top-1716877928 svg {
      position: relative;
      display: block;
      width: calc(159% + 1.3px);
      height: 148px;
    }

    .custom-shape-divider-top-1716877928 .shape-fill {
      fill: #5174db;
    }

    .loginFormContainer {
      max-width: 500px;
      height: 100%;
      background: rgb(35, 46, 209);
      background: linear-gradient(0deg, rgba(35, 46, 209, 0.5) 0%, rgba(225, 226, 254, 0.5842669831604517) 17%, rgba(255, 255, 255, 1) 64%);
    }

    .loginWholeContainer {
      width: 90%;
      height: 80%;
    }

    .loginFormImageContainer {
      height: 50%
    }

    .loginFormImage {
      max-width: 300px;
      width: 100%;
    }

    .loginGlobalImageContainer {
      width: 60%;
      height: 100%;
      overflow: hidden;
    }

    .loginGlobalImage {
      height: 100%;
    }

    #loginBtn {
      width: 80%;
    }

    .swal2-container {
      z-index: 1000;
    }
  </style>
  <!-- Jquery, Popper, Bootstrap -->
  <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</head>

<body class="d-flex row align-items-center justify-content-center">
  <div class="container loginWholeContainer d-flex m-auto align-items-center justify-content-center">
    <div class="container loginFormContainer d-flex flex-column border-dark-subtle rounded-start border-3 m-0 align-items-center justify-content-evenly shadow-lg p-2 p-lg-3">
      <div class="loginFormImageContainer d-flex align-items-center justify-content-center">
        <img class="loginFormImage" src="assets/img/logoCharmsComplete.png">
      </div>
      <form id="loginForm" method="post" action="<?= Flight::request()->base ?>/login" class="logForm row g-3 rounded col d-flex flex-column align-items-center">
        <input type="text" class="form-control" id="inputUsernameLog" name="inputUsernameLog" placeholder="Username" required>
        <input type="password" class="form-control" id="inputPasswordLog" name="inputPasswordLog" placeholder="Password" required>
        <div id="loginAlert" class="alert alert-danger alert-dismissible d-none" role="alert">
        </div>
        <div class="text-center col-12">
          <div id="loginLoading" class="spinner-border text-secondary text-center m-auto" role="status" style="display: none">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        <button type="submit" id="loginBtn" name="loginBtn" class="btn btn-primary">Login</button>
        <a href="register.php" class="link-underline-opacity-10 link-dark link-underline-opacity-50-hover text-center">Sign Up Instead</a>
      </form>
    </div>
    <div class="container loginGlobalImageContainer m-0 p-0 rounded-end d-none d-lg-block">
      <img class="loginGlobalImage" src="assets/img/loginImage.jpg">
    </div>
  </div>
  <script>
    <?php
    if ($invalid) {
    ?>
      Swal.fire({
        icon: 'error',
        title: 'Account Not Found',
        heightAuto: false
      })
    <?php
    } ?>
  </script>
</body>

</html>
