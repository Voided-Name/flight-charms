<?php
bdump($region);
bdump($province);
bdump($municipality);
bdump($barangay);

?>
<input type="hidden" id="currentRegion" name="currentRegion" value="<?= htmlspecialchars($region) ?>">
<input type="hidden" id="currentProvince" name="currentProvince" value="<?= htmlspecialchars($province) ?>">
<input type="hidden" id="currentMunicipality" name="currentMunicipality" value="<?= htmlspecialchars($municipality) ?>">
<input type="hidden" id="currentBarangay" name="currentBarangay" value="<?= htmlspecialchars($barangay) ?>">

<div class="row">
  <div class="col-6">
    <ul class="list-group">
      <li class="list-group-item">
        </select>
        <input class="form-check-input me-1" type="checkbox" value="regionCheckVal" hx-get="<?= Flight::request()->base ?>/locations/regions" hx-target="#regions" hx-trigger="change" id="regionCheckbox" name="locationCheckboxes[]" hx-include="#currentRegion" <?php if ($region != '0') {

                                                                                                                                                                                                                                                                      echo "checked";
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                    ?>>
        <label class="form-check-label" for="regionCheckbox" id="regionCheckLabel">Region</label>
      </li>
      <li class="list-group-item">
        <input class="form-check-input me-1" type="checkbox" value="provinceCheckVal" id="provinceCheckbox" name="locationCheckboxes[]" hx-get="<?= Flight::request()->base ?>/locations/provinces" hx-target="#provinces" hx-trigger="change" hx-include="#regions, #currentProvince" <?php if ($province != '0') {
                                                                                                                                                                                                                                                                                          echo "checked";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                          echo " hidden";
                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                        ?>>
        <label class="form-check-label" for="provinceCheckbox" id="provinceCheckLabel">Province</label>
      </li>
      <li class="list-group-item">
        <input class="form-check-input me-1" type="checkbox" value="municipalityCheckVal" id="municipalityCheckbox" name="locationCheckboxes[]" hx-get="<?= Flight::request()->base ?>/locations/municipalities" hx-target="#municipalities" hx-trigger="change" hx-include="#regions, #provinces, #currentMunicipality" <?php if ($municipality != '0') {
                                                                                                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                                                                                                            echo " hidden";
                                                                                                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                                                                                                          ?>>
        <label class="form-check-label" for="municipalityCheckbox" id="municipalityCheckLabel">Municipality</label>
      </li>
      <li class="list-group-item">
        <?php bdump($barangay == '0') ?>
        <input class="form-check-input me-1" type="checkbox" value="barangayCheckVal" id="barangayCheckbox" name="locationCheckboxes[]" hx-get=" <?= Flight::request()->base ?>/locations/barangays" hx-target="#barangays" hx-trigger="change" hx-include="#regions, #provinces, #municipalities, #currentBarangay" <?php if ($barangay != '0') {
                                                                                                                                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                                                                                                                                      } else {
                                                                                                                                                                                                                                                                                                                        echo "hidden";
                                                                                                                                                                                                                                                                                                                      }
                                                                                                                                                                                                                                                                                                                      ?>>
        <label class=" form-check-label" for="barangayCheckbox" id="barangayCheckLabel">Barangay</label>
      </li>
    </ul>
  </div>
  <div class="col-6">
    <select class="form-select " id="regions" disabled name="regions" hx-get="<?= Flight::request()->base ?>/locations/provinces" hx-target="#provinces" hx-trigger="change">
      <option selected="" disabled>Region</option>
    </select>
    <select class="form-select " id="provinces" disabled name="provinces" hx-get="<?= Flight::request()->base ?>/locations/municipalities" hx-target="#municipalities" hx-trigger="change" hx-include="#regions" <?php echo $region != '0' ? "" : "hidden" ?>>
      <option selected="" disabled>Province</option>
    </select>
    <select class="form-select " id="municipalities" disabled name="municipalities" hx-get="<?= Flight::request()->base ?>/locations/barangays" hx-target="#barangays" hx-trigger="change" hx-include="#regions, #provinces" <?php echo $province != '0' ? "" : "hidden" ?>>
      <option selected="" disabled>Municipality</option>
    </select>
    <select class="form-select " id="barangays" disabled name="barangays" <?php echo $municipality != '0' ? "" : "hidden" ?>>
      <option selected="" disabled>Barangay</option>
    </select>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('regionCheckbox').checked) {
      htmx.trigger('#regionCheckbox', 'change');

      htmx.on('#regions', 'htmx:afterSwap', function(evt) {
        if (document.getElementById('provinceCheckbox').checked) {
          htmx.trigger('#provinceCheckbox', 'change');

          htmx.on('#provinces', 'htmx:afterSwap', function(evt) {
            if (document.getElementById('municipalityCheckbox').checked) {
              htmx.trigger('#municipalityCheckbox', 'change');

              htmx.on('#municipalities', 'htmx:afterSwap', function(evt) {
                if (document.getElementById('barangayCheckbox').checked) {
                  htmx.trigger('#barangayCheckbox', 'change');
                }
              });
            }
          });
        }
      });
    }
  }, false);

  document.getElementById('regionCheckbox').addEventListener('change', function() {
    if (this.checked) {
      document.getElementById('regions').disable = false;
    } else {
      document.getElementById('regions').disable = true;
    }
  });

  document.getElementById('regionCheckbox').addEventListener('change', function() {
    document.getElementById('regions').disabled = !this.checked;
    if (!this.checked) {
      document.getElementById('provinces').innerHTML = '';
      document.getElementById('municipalities').innerHTML = '';
      document.getElementById('barangays').innerHTML = '';

      document.getElementById('provinces').disabled = true;
      document.getElementById('provinceCheckbox').checked = false;

      document.getElementById('municipalities').disabled = true;
      document.getElementById('municipalityCheckbox').checked = false;

      document.getElementById('barangays').disabled = true;
      document.getElementById('barangayCheckbox').checked = false;

      document.getElementById('provinces').hidden = true;
      document.getElementById('provinceCheckbox').hidden = true;

      document.getElementById('municipalities').hidden = true;
      document.getElementById('municipalityCheckbox').hidden = true;

      document.getElementById('barangays').hidden = true;
      document.getElementById('barangayCheckbox').hidden = true;
    } else {
      document.getElementById('provinces').hidden = false;
      document.getElementById('provinceCheckbox').hidden = false;
      htmx.trigger('#regions', 'change');
    }
  });

  document.getElementById('provinceCheckbox').addEventListener('change', function() {
    document.getElementById('provinces').disabled = !this.checked;
    if (!this.checked) {
      document.getElementById('provinces').innerHTML = '';
      document.getElementById('municipalities').innerHTML = '';
      document.getElementById('barangays').innerHTML = '';


      document.getElementById('municipalities').disabled = true;
      document.getElementById('municipalityCheckbox').checked = false;

      document.getElementById('barangays').disabled = true;
      document.getElementById('barangayCheckbox').checked = false;

      document.getElementById('municipalities').hidden = true;
      document.getElementById('municipalityCheckbox').hidden = true;

      document.getElementById('barangays').hidden = true;
      document.getElementById('barangayCheckbox').hidden = true;
    } else {
      document.getElementById('regions').disabled = false;
      document.getElementById('regionCheckbox').checked = true;

      document.getElementById('municipalities').hidden = false;
      document.getElementById('municipalityCheckbox').hidden = false;
    }
  });

  document.getElementById('municipalityCheckbox').addEventListener('change', function() {
    document.getElementById('municipalities').disabled = !this.checked;
    if (!this.checked) {
      document.getElementById('municipalities').innerHTML = '';
      document.getElementById('barangays').innerHTML = '';

      document.getElementById('barangays').disabled = true;
      document.getElementById('barangayCheckbox').checked = false;

      document.getElementById('barangays').hidden = true;
      document.getElementById('barangayCheckbox').hidden = true;
    } else {
      document.getElementById('regions').disabled = false;
      document.getElementById('regionCheckbox').checked = true;

      document.getElementById('provinces').disabled = false;
      document.getElementById('provinceCheckbox').checked = true;

      document.getElementById('barangays').hidden = false;
      document.getElementById('barangayCheckbox').hidden = false;
    }
  });

  document.getElementById('barangayCheckbox').addEventListener('change', function() {
    document.getElementById('barangays').disabled = !this.checked;
    if (!this.checked) {
      document.getElementById('barangays').innerHTML = '';
    } else {
      document.getElementById('regions').disabled = false;
      document.getElementById('regionCheckbox').checked = true;

      document.getElementById('provinces').disabled = false;
      document.getElementById('provinceCheckbox').checked = true;

      document.getElementById('municipalities').disabled = false;
      document.getElementById('municipalityCheckbox').checked = true;
    }
  });
</script>
