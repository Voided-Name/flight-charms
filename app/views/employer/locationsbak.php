                <div class="row mb-2">
                  <div class="col-12">
                    <legend>Location of Deployment</legend>
                  </div>
                  <div class="col-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="regionCheckVal" id="regionCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_region']) {
                                                                                                                                                      echo "checked";
                                                                                                                                                    }
                                                                                                                                                    ?>>
                        <label class="form-check-label" for="regionCheckbox">Region</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="provinceCheckVal" id="provinceCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_province']) {
                                                                                                                                                          echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
                        <label class="form-check-label" for="provinceCheckbox">Province</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="municipalityCheckVal" id="municipalityCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_municipality']) {
                                                                                                                                                                  echo "checked";
                                                                                                                                                                }
                                                                                                                                                                ?>>
                        <label class="form-check-label" for="municipalityCheckbox">Municipality</label>
                      </li>
                      <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="barangayCheckVal" id="barangayCheckbox" name="locationCheckboxes[]" <?php if ($vacanciesData[$_GET['editBtnVal']]['job_barangay']) {
                                                                                                                                                          echo "checked";
                                                                                                                                                        }
                                                                                                                                                        ?>>
                        <label class="form-check-label" for="barangayCheckbox">Barangay</label>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <select class="form-select " id="regions" disabled style="display:none" name="regions">
                      <option selected="" disabled>Region</option>
                    </select>
                    <select class="form-select " id="provinces" disabled style="display:none" name="provinces">
                      <option selected="" disabled>Province</option>
                    </select>
                    <select class="form-select " id="municipalities" disabled style="display:none" name="municipalities">
                      <option selected="" disabled>Municipality</option>
                    </select>
                    <select class="form-select " id="barangays" disabled style="display:none" name="barangays">
                      <option selected="" disabled>Barangay</option>
                    </select>
                  </div>
                </div>
