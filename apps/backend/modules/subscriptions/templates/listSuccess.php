<?php use_helper('dtBoolValue', 'dtForm', 'Number'); ?>

<table class="zebra">
  <thead>
    <tr>
      <th>Title</th>
      <th>Pre-Appr.</th>
      <th>Profiles</th>
      <th>Photos</th>
      <th>Winks</th>
      <th>Read Mess.</th>
      <th>Reply Mess.</th>
      <th>Send Mess.</th>
      <th>See profile viewed</th>
      <th>Contact Ass.</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
  <?php $last_cat = null; ?>
  <?php foreach ($subscriptions as $sub): ?>
      <?php if( $last_cat != $sub->getCatId() ): ?>
          <?php $last_cat = $sub->getCatId(); ?>
          <tr>
            <th colspan="11" style="text-align: center;"><?php echo $sub->getCatalogue(); ?></th>
          </tr>
      <?php endif; ?>
      <tr rel="<?php echo url_for('subscriptions/edit?id=' . $sub->getSubscriptionId() . '&cat_id=' . $sub->getCatId()); ?>">
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
        <td><?php echo ($sub->getAmount() == 0) ? "free" : (format_currency($sub->getAmount()) .'&nbsp;'.$sub->getCurrency(). '/' . $sub->getPeriod() . ' ' . pr_format_payment_period_type($sub->getPeriodType())); ?></td>
      </tr>
  <?php endforeach; ?>
  </tbody>
</table>
