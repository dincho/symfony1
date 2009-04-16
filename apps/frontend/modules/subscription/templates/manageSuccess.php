<?php echo __('Manage subscription - membership status'); ?>

<?php if( $member->getLastPaypalItem() == 'membership'): ?>
    <?php if( is_null($member->getPaypalUnsubscribedAt()) ): ?>
        <?php echo __('Manage subscription - auto-renewal', array('%EOT_DATE%' => date('M d, Y', $member->getEotDate()))); ?>
        <?php echo button_to(__('Unsubscribe'), sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')), array('popup' => true, 'class' => 'button')) ?>    
    <?php else: ?>
         <?php echo __('Manage subscription - subscription canceled'); ?>
    <?php endif; ?>
<?php else: //gift membership ?>
    <?php echo __('Manage subscription - gift membership'); ?>
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>