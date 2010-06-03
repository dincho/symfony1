<?php slot('header_title') ?>
<?php echo __('Delete Your Account') ?>
<?php end_slot(); ?>

<?php echo __('Your account has been deleted.') ?>

             
<?php $member = $sf_user->getProfile(); ?>
<?php $current_member_subscription = $member->getCurrentMemberSubscription(); ?>

<?php if( $current_member_subscription && 
          $current_member_subscription->getStatus() != 'canceled' &&
          $current_member_subscription->getLastCompletedPayment()->getPaymentProcessor() == 'paypal' ): ?>

<?php $cancel_url = sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')); ?>
<?php echo __('Delete account - you have active subscription', array('%SUBSCRIPTION_CANCEL_URL%' => $cancel_url)); ?>


<script type="text/javascript" charset="utf-8">
  setTimeout("window.location = '<?php echo $cancel_url; ?>'", 5000);
</script>
<?php endif; ?>