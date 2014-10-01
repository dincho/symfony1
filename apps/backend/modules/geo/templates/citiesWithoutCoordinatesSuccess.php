<?php use_helper('Number', 'xSortableTitle', 'I18N') ?>

<div class="filter_right">
    Total: <?php echo format_number($pager->getNbResults()) ?>
</div>

<table class="zebra">
  <thead>
    <tr>
      <th><?php echo sortable_title('Joined', 'Member::created_at', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Country', 'Geo::country', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ADM1', 'Geo::adm1', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ADM2', 'Geo::adm2', $sort_namespace) ?></th>
      <th><?php echo sortable_title('City', 'Geo::name', $sort_namespace) ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $member): ?>
  <tr>
    <td><?php echo $member->getCreatedAt('m/d/Y') ?></td>
    <td><?php echo link_to($member->getUsername(), 'members/editRegistration?id=' . $member->getId()) ?></td>
    <td><?php echo format_country($member->getCountry()) ?></td>
    <td><?php echo $member->getCity()->getAdm1() ?></td>
    <td><?php echo $member->getCity()->getAdm2() ?></td>
    <?php $ret_uri = base64_encode('geo/citiesWithoutCoordinates?cancel=1&page=' . $sf_request->getParameter('page', 1)); ?>
    <td><?php echo link_to($member->getCity(), 'geo/edit?id=' . $member->getCityId() .
                            '&ret_uri=' . $ret_uri) ?></td>

  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'geo/citiesWithoutCoordinates')); ?>
