<?php foreach ($provinces as $provinceName => $provinceData): ?>
  <option value="<?= htmlspecialchars($provinceName) ?>" <?php echo $currentProvince == $provinceName ? "selected" : "" ?>>
    <?= htmlspecialchars($provinceName) ?>
  </option>
<?php endforeach; ?>
