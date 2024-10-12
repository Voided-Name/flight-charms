<?php foreach ($barangays as $barangayName => $barangayData): ?>
  <option value="<?= htmlspecialchars($barangayData) ?>">
    <?= htmlspecialchars($barangayData) ?>
  </option>
<?php endforeach; ?>
