  <header>
    <!-- Header Start -->
    <div class="header-area header-transparrent">
      <div class="header-top header-sticky">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-3 col-md-2">
              <!-- Logo -->
              <div class="logo">
                <a href="<?= Flight::request()->base ?>"><img src="assets/img/logoCharmsComplete.png" style="height: 70px" alt=""></a>
              </div>
            </div>
            <div class="col-lg-9 col-md-9">
              <div class="menu-wrapper">
                <!-- Main-menu -->
                <div class="main-menu">
                  <nav class="d-none d-lg-block">
                    <ul id="navigation">
                      <li><a href="<?= Flight::request()->base ?>" <?= $homestyle ?>>Home</a></li>
                      <li><a href="<?= Flight::request()->base ?>/about" <?= $aboutstyle ?>>About</a></li>
                      <li><a href="<?= Flight::request()->base ?>/contact" <?= $contactstyle ?>>Contact</a></li>
                    </ul>
                  </nav>
                </div>
                <!-- Header-btn -->
                <div class="header-btn d-none f-right d-lg-block">
                  <a href="<?= Flight::request()->base ?>/register" class="btn head-btn2">Register</a>
                  <a href="<?= Flight::request()->base ?>/login" class="btn head-btn2">Login</a>
                </div>
              </div>
            </div>
            <!-- Mobile Menu -->
            <div class="col-12">
              <div class="mobile_menu d-block d-lg-none"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Header End -->
  </header>
