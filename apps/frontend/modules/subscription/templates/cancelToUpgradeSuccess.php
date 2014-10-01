<?php echo __('Cancel to upgrade instructions'); ?>

<?php if( $last_payment->getPaymentProcessor() == 'paypal' ): ?>
    <?php echo button_to(__('Unsubscribe'), $member_subscription->getUnsubscribeUrl(),
                            array('popup' => true, 'class' => 'button')) ?>

<?php elseif( $last_payment->getPaymentProcessor() == 'zong' ): ?>

      <?php echo button_to(__('Unsubscribe'), 'subscription/cancelToUpgrade?cancelCurrent=1&sid=' . $sf_request->getParameter('sid'),
                            array('popup' => true, 'class' => 'button')) ?>
<?php endif; ?>
