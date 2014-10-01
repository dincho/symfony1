<table>
<tr>
<th width="50%">Property</th><th width="505">Value</th>
</tr>
  <?php if($exif_info): ?>
    <?php foreach ($exif_info as $key => $section): ?>
      <?php foreach ($section as $name => $val): ?>
        <tr><td><?php echo "$key.$name:"; ?></td><td><?php echo (is_array($val) ? implode(', ', $val): $val); ?></td></tr>
      <?php endforeach; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</table>
