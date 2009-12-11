<?php use_helper('Number', 'xSortableTitle', 'I18N') ?>

<table class="zebra">
  <thead>
    <tr>
        <th>Country</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($countries_diff as $country): ?>
  <tr rel="<?php echo url_for('geo/list?filter=filter&filters[country][]=' . $country); ?>">
    <td><?php echo format_country($country); ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

