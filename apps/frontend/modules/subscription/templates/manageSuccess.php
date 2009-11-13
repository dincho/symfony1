<?php use_helper('Number', 'Date') ?>
<?php echo __('Manage subscription - membership status'); ?>

<?php if( $member->getLastPaypalItem() == 'membership'): //normal membership by member ?>
    <?php if( is_null($member->getPaypalUnsubscribedAt()) ): //still not canceled subscription ?>
        <?php echo __('Manage subscription - auto-renewal', 
                      array('%EOT_DATE%' => format_date($member->getEotDate(null), 'MMM dd, yyyy'),
                            '%NEXT_PAYMENT_DATE%' => format_date($member->getNextPaymentDate(null), 'MMM dd, yyyy'),
                            '%NEXT_PAYMENT_AMOUNT%' => format_currency($member->getNextPaymentAmount(), 'GBP'),
                      )); ?>
        <?php echo button_to(__('Unsubscribe'), sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')), array('popup' => true, 'class' => 'button')) ?>    
    <?php else: ?>
         <?php echo __('Manage subscription - subscription canceled', array('%EOT_DATE%' => format_date($member->getEotDate(null), 'MMM dd, yyyy'))); ?>
    <?php endif; ?>
<?php elseif( $member->getLastPaypalItem() == 'gift_membership' ): //gift membership ?>
    <?php echo __('Manage subscription - gift membership', array('%EOT_DATE%' => format_date($member->getEotDate(null), 'MMM dd, yyyy')) ); ?>
<?php else: ?>
    <?php echo __('Manage subscription - membership by admin'); ?>
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>