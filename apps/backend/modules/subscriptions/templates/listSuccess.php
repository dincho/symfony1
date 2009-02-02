<?php use_helper('dtBoolValue'); ?>

<table class="zebra">
  <thead>
    <tr>
      <th>Title</th>
      <th>Pre-Approval</th>
      <th>Profiles</th>
      <th>Photos</th>
      <th>Whinks</th>
      <th>Read Messages</th>
      <th>Reply Messages</th>
      <th>Send Messages</th>
      <th>See profile viewed</th>
      <th>Contact Assistant</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($subscriptions as $sub): ?>
  <tr rel="<?php echo url_for('subscriptions/edit?id=' . $sub->getId()); ?>">
    <td><?php echo $sub->getTitle() ?></td>
    <td><?php echo boolValue($sub->getPreApprove()) ?>
    <td><?php echo boolColor($sub->getCreateProfiles(), $sub->getCanCreateProfile()) ?></td>
    <td><?php echo boolColor($sub->getPostPhotos(), $sub->getCanPostPhoto()) ?></td>
    <td><?php echo boolColor($sub->getWinks(), $sub->getCanWink()) ?></td>
    <td><?php echo boolColor($sub->getReadMessages(), $sub->getCanReadMessages()) ?></td>
    <td><?php echo boolColor($sub->getReplyMessages(), $sub->getCanReplyMessages()) ?></td>
    <td><?php echo boolColor($sub->getSendMessages(), $sub->getCanSendMessages()) ?></td>
    <td><?php echo boolColor($sub->getSeeViewed(), $sub->getCanSeeViewed()) ?></td>
    <td><?php echo boolColor($sub->getContactAssistant(), $sub->getCanContactAssistant()) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

