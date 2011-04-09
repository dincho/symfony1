<?php use_helper('Number', 'I18N') ?>

<?php $ret_uri = base64_encode(url_for('geo/emptyAdm1?page=' . $page . '&per_page=' . $limit, array('abosulute' => true))); ?>

<table class="zebra">
  <thead>
    <tr>
      <th>ID</th>
      <th>Country</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($geos as $geo): ?>
  <tr rel="<?php echo url_for('geo/edit?id=' . $geo->getId() . '&ret_uri=' .$ret_uri); ?>">
    <td><?php echo $geo->getId() ?></td>
    <td><?php echo format_country($geo->getCountry()) ?></td>
    <td><?php echo $geo->getName() ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('simple_pager', array('limit' => $limit, 'page' => $page,  'route' => 'geo/emptyAdm1', )); ?>
