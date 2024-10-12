<?php foreach ($provinces as $provinceName => $provinceData): ?>
  <option value="<?= htmlspecialchars($provinceName) ?>">
    <?= htmlspecialchars($provinceName) ?>
  </option>
<?php endforeach; ?>
