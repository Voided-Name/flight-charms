<?php foreach ($regions as $key => $region): ?>
  <option value="<?= htmlspecialchars($key) ?>">
    <?= htmlspecialchars($region['region_name']) ?>
  </option>
<?php endforeach; ?>
