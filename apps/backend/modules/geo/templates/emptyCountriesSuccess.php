<?php use_helper('Number', 'I18N') ?>

<table class="zebra">
  <thead>
    <tr>
      <th>ID</th>
      <th>ISO Code</th>
      <th>Name</th>
      <th>Name I18N</th>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($geos as $geo): ?>
  <tr rel="<?php echo url_for('geo/list?filter=filter&filters[country][]=' . $geo->getCountry()); ?>">
    <td><?php echo $geo->getId() ?></td>
    <td><?php echo $geo->getCountry() ?></td>
    <td><?php echo $geo->getName() ?></td>
    <td><?php echo format_country($geo->getCountry()) ?></td>    
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('simple_pager', array('limit' => $limit, 'page' => $page,  'route' => 'geo/emptyCountries', )); ?>
