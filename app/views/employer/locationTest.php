<!doctype html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CICT CHARM</title>

  <link rel="shortcut icon" href="<?= Flight::request()->base ?>/assets/img/favicon.ico">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/core/libs.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1_vendor/aos/dist/aos.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/hope-ui.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/custom.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/dark.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/rtl.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/theme_1/customizer.min.css">
  <link rel="stylesheet" href="<?= Flight::request()->base ?>/assets/css/mycss.css">
  <script src="https://unpkg.com/htmx.org@2.0.3"></script>

</head>

<body>
  <!-- Region Checkbox and Select -->
  <label>
    <input type="checkbox" id="regionCheckbox" name="regionCheckbox" hx-get="<?= Flight::request()->base ?>/locations/regions" hx-target="#regions" hx-trigger="load from:body">
    Select Region
  </label>
  <select id="regions" name="regions" hx-get="<?= Flight::request()->base ?>/locations/provinces" hx-target="#provinces" hx-trigger="change">
    <!-- Options will be loaded here -->
  </select>

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

  <script>
    // Enable or disable selects based on checkboxes
    /*document.getElementById('regionCheckbox').addEventListener('change', function() {*/
    /*  document.getElementById('regions').disabled = !this.checked;*/
    /*  if (!this.checked) {*/
    /*    document.getElementById('regions').innerHTML = '';*/
    /*    document.getElementById('provinces').innerHTML = '';*/
    /*    document.getElementById('municipalities').innerHTML = '';*/
    /*    document.getElementById('barangays').innerHTML = '';*/
    /**/
    /*    document.getElementById('provinces').disabled = true;*/
    /*    document.getElementById('provinceCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('municipalities').disabled = true;*/
    /*    document.getElementById('municipalityCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('barangays').disabled = true;*/
    /*    document.getElementById('barangayCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('provinces').hidden = true;*/
    /*    document.getElementById('provinceCheckbox').hidden = true;*/
    /**/
    /*    document.getElementById('municipalities').hidden = true;*/
    /*    document.getElementById('municipalityCheckbox').hidden = true;*/
    /*  } else {*/
    /*    document.getElementById('provinces').hidden = false;*/
    /*    document.getElementById('provinceCheckbox').hidden = false;*/
    /*  }*/
    /*});*/
    /**/
    /*document.getElementById('provinceCheckbox').addEventListener('change', function() {*/
    /*  document.getElementById('provinces').disabled = !this.checked;*/
    /*  if (!this.checked) {*/
    /*    document.getElementById('provinces').innerHTML = '';*/
    /*    document.getElementById('municipalities').innerHTML = '';*/
    /*    document.getElementById('barangays').innerHTML = '';*/
    /**/
    /**/
    /*    document.getElementById('municipalities').disabled = true;*/
    /*    document.getElementById('municipalityCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('barangays').disabled = true;*/
    /*    document.getElementById('barangayCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('municipalities').hidden = true;*/
    /*    document.getElementById('municipalityCheckbox').hidden = true;*/
    /**/
    /*    document.getElementById('barangays').hidden = true;*/
    /*    document.getElementById('barangayCheckbox').hidden = true;*/
    /*  } else {*/
    /*    document.getElementById('regions').disabled = false;*/
    /*    document.getElementById('regionCheckbox').checked = true;*/
    /**/
    /*    document.getElementById('municipalities').hidden = false;*/
    /*    document.getElementById('municipalityCheckbox').hidden = false;*/
    /*  }*/
    /*});*/
    /**/
    /*document.getElementById('municipalityCheckbox').addEventListener('change', function() {*/
    /*  document.getElementById('municipalities').disabled = !this.checked;*/
    /*  if (!this.checked) {*/
    /*    document.getElementById('municipalities').innerHTML = '';*/
    /*    document.getElementById('barangays').innerHTML = '';*/
    /**/
    /*    document.getElementById('barangays').disabled = true;*/
    /*    document.getElementById('barangayCheckbox').checked = false;*/
    /**/
    /*    document.getElementById('barangays').hidden = true;*/
    /*    document.getElementById('barangayCheckbox').hidden = true;*/
    /*  } else {*/
    /*    document.getElementById('regions').disabled = false;*/
    /*    document.getElementById('regionCheckbox').checked = true;*/
    /**/
    /*    document.getElementById('provinces').disabled = false;*/
    /*    document.getElementById('provinceCheckbox').checked = true;*/
    /**/
    /*    document.getElementById('barangays').hidden = false;*/
    /*    document.getElementById('barangayCheckbox').hidden = false;*/
    /*  }*/
    /*});*/
    /**/
    /*document.getElementById('barangayCheckbox').addEventListener('change', function() {*/
    /*  document.getElementById('barangays').disabled = !this.checked;*/
    /*  if (!this.checked) {*/
    /*    document.getElementById('barangays').innerHTML = '';*/
    /*  } else {*/
    /*    document.getElementById('regions').disabled = false;*/
    /*    document.getElementById('regionCheckbox').checked = true;*/
    /**/
    /*    document.getElementById('provinces').disabled = false;*/
    /*    document.getElementById('provinceCheckbox').checked = true;*/
    /**/
    /*    document.getElementById('municipalities').disabled = false;*/
    /*    document.getElementById('municipalityCheckbox').checked = true;*/
    /*  }*/
    /*});*/
  </script>

</body>

</html>
