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
          <button type="button" class=" col-md-12 col-lg-5 btn btn-primary p-2 m-2 fs-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Generate Report
          </button>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Generate Report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="admin/generateReport">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="reportValues[]" value="users" id="techHtml">
                <label class="form-check-label" for="techHtml">
                  List of Users
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="reportValues[]" value="vacancies" id="techCss">
                <label class="form-check-label" for="techCss">
                  Vacancies
                </label>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
