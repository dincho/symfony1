<?php use_helper('xSortableTitle') ?>
<table class="zebra">
  <thead>
    <tr>

        <th><?php echo sortable_title('Registered', 'Member::created_at', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Days In', 'MemberImbra::created_at', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
        <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Last Name', 'Member::last_name', $sort_namespace) ?></th>
        <th><?php echo sortable_title('First Name', 'Member::first_name', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Sub', 'Member::subscription_id', $sort_namespace) ?></th>      
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