<br>

<label>
  <input type="checkbox" id="provinceCheckbox" name="provinceCheckbox">
  Select Province
</label>
<select id="provinces" name="provinces" hx-get="<?= Flight::request()->base ?>/locations/municipalities" hx-target="#municipalities" hx-trigger="change" hx-include="#regions">
  <!-- Options will be loaded here -->
</select>

<br>

<!-- Municipality Checkbox and Select -->
<label>
  <input type="checkbox" id="municipalityCheckbox" name="municipalityCheckbox">
  Select Municipality
</label>
<select id="municipalities" name="municipalities" hx-get="<?= Flight::request()->base ?>/locations/barangays" hx-target="#barangays" hx-trigger="change" hx-include="#regions, #provinces">
  <!-- Options will be loaded here -->
</select>

<br>

<!-- Barangay Checkbox and Select -->
<label>
  <input type="checkbox" id="barangayCheckbox" name="barangayCheckbox">
  Select Barangay
</label>
<select id="barangays" name="barangays">
  <!-- Options will be loaded here -->
</select>

<br>

<div class="row">
  <div class="col-6">
    <ul class="list-group">
      <li class="list-group-item">
        <label>
          <input type="checkbox" id="regionCheckbox" name="regionCheckbox" hx-get="<?= Flight::request()->base ?>/locations/regions" hx-target="#regions" hx-trigger="change from:body">
          Select Region
        </label>
        <select id="regions" name="regions" hx-get="<?= Flight::request()->base ?>/locations/provinces" hx-target="#provinces" hx-trigger="change">
          <!-- Options will be loaded here -->
        </select>
        <input class="form-check-input me-1" type="checkbox" value="regionCheckVal" hx-get="<?= Flight::request()->base ?>/locations/regions" hx-target="#regions" hx-trigger="load from:body" id="regionCheckbox" name="locationCheckboxes[]" <?php if ($region != '0') {
                                                                                                                                                                                                                                                  echo "checked";
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                ?>>
        <label class="form-check-label" for="regionCheckbox">Region</label>
      </li>
      <li class="list-group-item">
        <input class="form-check-input me-1" type="checkbox" value="provinceCheckVal" id="provinceCheckbox" name="locationCheckboxes[]" <?php if ($province != '0') {
                                                                                                                                          echo "checked";
                                                                                                                                        }
                                                                                                                                        ?>>
        <label class="form-check-label" for="provinceCheckbox">Province</label>
      </li>
      <li class="list-group-item">
        <input class="form-check-input me-1" type="checkbox" value="municipalityCheckVal" id="municipalityCheckbox" name="locationCheckboxes[]" <?php if ($municipality != '0') {
                                                                                                                                                  echo "checked";
                                                                                                                                                }
                                                                                                                                                ?>>
        <label class="form-check-label" for="municipalityCheckbox">Municipality</label>
      </li>
      <li class="list-group-item">
        <input class="form-check-input me-1" type="checkbox" value="barangayCheckVal" id="barangayCheckbox" name="locationCheckboxes[]" <?php if ($barangay != '0') {
                                                                                                                                          echo "checked";
                                                                                                                                        }
                                                                                                                                        ?>>
        <label class="form-check-label" for="barangayCheckbox">Barangay</label>
      </li>
    </ul>
  </div>
  <div class="col-6">
    <select class="form-select " id="regions" disabled name="regions">
      <option selected="" disabled>Region</option>
    </select>
    <select class="form-select " id="provinces" disabled name="provinces">
      <option selected="" disabled>Province</option>
    </select>
    <select class="form-select " id="municipalities" disabled name="municipalities">
      <option selected="" disabled>Municipality</option>
    </select>
    <select class="form-select " id="barangays" disabled name="barangays">
      <option selected="" disabled>Barangay</option>
    </select>
  </div>
</div>

<script>
  document.getElementById('regionCheckbox').addEventListener('change', function() {
    if (this.checked) {
      document.getElementById('regions').disable = false;
    } else {
      document.getElementById('regions').disable = true;
    }
  });
</script>
