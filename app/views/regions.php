<?php bdump($region) ?>
<?php foreach ($regions as $key => $regionInstance): ?>
  <option value="<?= htmlspecialchars($key) ?>" <?php echo $region == $key ? "selected" : "" ?>>
    <?= htmlspecialchars($regionInstance['region_name']) ?>
  </option>
<?php endforeach; ?>
