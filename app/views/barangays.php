<?php foreach ($barangays as $barangayName => $barangayData): ?>
  <option value="<?= htmlspecialchars($barangayData) ?>" <?php echo $currentBarangay == $barangayData ? "selected" : "" ?>>
    <?= htmlspecialchars($barangayData) ?>
  </option>
<?php endforeach; ?>
