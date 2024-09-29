<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="row row-cols-1">
        <div class="overflow-hidden d-slider1 ">
          <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
              <div class="card-body">
                <div class="progress-widget">
                  <div class="progress-detail">
                    <p class="mb-2">Job Vacancies</p>
                    <h4 class="counter"><?php echo $numVacancies ?></h4>
                  </div>
                </div>
              </div>
            </li>
            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
              <div class="card-body">
                <div class="progress-widget">
                  <div class="progress-detail">
                    <p class="mb-2">Alumnis</p>
                    <h4 class="counter"><?php echo $numAlumnis ?></h4>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card" data-aos="fade-up" data-aos-delay="800">
        <div class="flex-wrap row d-flex justify-content-evenly align-items-center p-3">
          <a href="<?= Flight::request()->base ?>/dashboard/admin/validate" class="col-md-12 col-lg-5 btn btn-primary p-2 m-2 fs-1">
            Validate Users
          </a>
          <a href="<?= Flight::request()->base ?>/dashboard/admin/list" class="col-md-12 col-lg-5 btn btn-secondary p-2 m-2 fs-1">
            List of Users
          </a>
          <a href="<?= Flight::request()->base ?>/dashboard/admin/generate" class="col-md-12 col-lg-5 btn btn-success p-2 m-2 fs-1">
            Generate Report
          </a>
        </div>
      </div>
    </div>
  </div>
