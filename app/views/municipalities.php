<?php foreach ($municipalities as $municipalityName => $municipalityData): ?>
  <option value="<?= htmlspecialchars($municipalityName) ?>">
    <?= htmlspecialchars($municipalityName) ?>
  </option>
<?php endforeach; ?>
