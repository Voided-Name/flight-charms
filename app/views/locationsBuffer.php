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
