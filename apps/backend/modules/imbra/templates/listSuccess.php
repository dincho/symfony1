<table class="zebra">
  <thead>
    <tr>
      <th>Registered</th>
      <th>Days In</th>
      <th>Username</th>
      <th>ID</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Sex</th>
      <th>Email</th>
      <th>Sub</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($imbra_applications as $imbra): ?>
  <?php $member = $imbra->getMember(); ?>
  <tr rel="<?php echo url_for('imbra/edit?filter=filter&filters[imbra_status_id]='.$filters['imbra_status_id'].'&member_id=' . $member->getId() . '&id=' . $imbra->getId()); ?>">
    <td><?php echo $member->getCreatedAt('m/d/Y') ?></td>
    <td><?php echo $imbra->getDaysIn(); ?></td>
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId(); ?></td>
    <td><?php echo $member->getLastName() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getSubscription() ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>