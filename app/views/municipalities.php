<?php foreach ($municipalities as $municipalityName => $municipalityData): ?>
  <option value="<?= htmlspecialchars($municipalityName) ?>" <?php echo $currentMunicipality == $municipalityName ? "selected" : "" ?>>
    <?= htmlspecialchars($municipalityName) ?>
  </option>
<?php endforeach; ?>
