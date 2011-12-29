<?php use_helper('Number', 'Date', 'Javascript') ?>
<?php $type = ($member_subscription) ? $member_subscription->getSubscription()->getTitle() : $member->getSubscription()->getTitle(); ?>

<?php if( $member_subscription ): ?>
    <?php $eot = format_date($member_subscription->getExtendedEOT(null), $date_format); ?>
    <?php echo __('Manage subscription - membership status', array('%SUBSCRIPTION_TYPE%' => $type, '%EOT_DATE%' => $eot)); ?>
    
    <?php if( $member_subscription->getStatus() == 'canceled' ): ?>
        <?php echo __('Manage subscription - subscription canceled', array('%SUBSCRIPTION_TYPE%' => $type, '%EOT_DATE%' => $eot)); ?>
    <?php else: ?>
        <?php if( $last_payment->getPaymentProcessor() == 'paypal' ): ?>
            <?php if( $member_subscription->getNextAmount() ): ?>
                <?php $next_payment_amount = format_currency($member_subscription->getNextAmount(), $member_subscription->getNextCurrency()); ?>
            <?php else: ?>
                <?php $next_payment_amount = format_currency($last_payment->getAmount(), $last_payment->getCurrency()); ?>
            <?php endif; ?>
            
            <?php echo __('Manage subscription - paypal', array('%SUBSCRIPTION_TYPE%' => $type,
                                                                '%EOT_DATE%' => $eot,
                                                                '%NEXT_PAYMENT_DATE%' => format_date($member_subscription->getEotAt(null), $date_format),
                                                                '%NEXT_PAYMENT_AMOUNT%' => $next_payment_amount)); ?>
                                                                
            <?php echo button_to(__('Unsubscribe'), sfConfig::get('app_paypal_url') . '?cmd=_subscr-find&alias=' . urlencode(sfConfig::get('app_paypal_business')), 
                                    array('popup' => true, 'class' => 'button')) ?>
                                    
        <?php elseif( $last_payment->getPaymentProcessor() == 'zong' ): ?>
            <?php echo __('Manage subscription - zong', array('%SUBSCRIPTION_TYPE%' => $type,
                                                              '%EOT_DATE%' => format_date($member_subscription->getExtendedEOT(), $date_format))); ?>
            
            <?php if( $zongAvailable ): ?>
                <?php $zong_pay_button = button_to_function(__('Pay with Zong+'), 'show_zong_payment();', array('class' => 'button', 'id' => 'zong_pay_button')); ?>
                <p id="zong_payment"><?php echo __('Manage subscription - zong pay button', array('%PAY_BUTTON%' => $zong_pay_button)); ?></p>
                <div id="zongPayment_container" style="display: none;"><?php echo __('Loading please wait ...'); ?></div>
                
                <script type="text/javascript" charset="utf-8">
                    function show_zong_payment()
                    {
                        $('zong_payment').hide();
                        $('zongPayment_container').show();
                        
                        <?php echo remote_function(array('update' => 'zongPayment_container', 'url' => 'ajax/zongPayment?msid=' . $member_subscription->getId())); ?>
                    }
                </script>
            <?php endif; ?>
            
        <?php elseif( $last_payment->getPaymentProcessor() == 'dotpay' ): ?>
            <?php echo __('Manage subscription - dotpay', array('%SUBSCRIPTION_TYPE%' => $type, '%EOT_DATE%' => $eot)); ?>
            
            <?php echo form_tag($sf_data->getRaw('dotpayURL'), array('method' => 'post', 'id' => 'dotpay_form')) ?>
                <?php echo submit_tag(__('Pay with DotPay'), array('class' => 'button', 'id' => 'dotpay_button')); ?>
            </form>
            
        <?php endif; ?>        
    <?php endif; ?>
    
<?php else: ?>
    <?php echo __('Manage subscription - membership status', array('%SUBSCRIPTION_TYPE%' => $type)); ?>
    <?php echo __('Manage subscription - membership by admin'); ?>
<?php endif; ?>

<?php if( $next_member_subscription ): ?>
    <?php echo __('Manage subscription - next subscription', array('%EFFECTIVE_DATE%' => format_date($next_member_subscription->getEffectiveDate(null), $date_format),
                                                                   '%EOT_DATE%' => format_date($next_member_subscription->getExtendedEOT(null), $date_format),
                                                                   '%SUBSCRIPTION_TYPE%' => $next_member_subscription->getSubscription()->getTitle(),
    )); ?>
<?php endif; ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
