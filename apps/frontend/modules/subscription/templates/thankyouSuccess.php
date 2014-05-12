<?php use_helper('Javascript'); ?>

<?php echo __('Thank you for your payment and for using our services.', array('%URL_FOR_DASHBOARD%' => url_for('dashboard/index'),
                                                                              '%URL_FOR_MATCHES%' => url_for('search/index'))) ?>

<?php if( isset($zongBonusEntryPointUrl) ): ?>
    <p><?php echo __('You earned Zong bonus, use the form below to extend your subscription end of term for free!'); ?></p>

    <div id="zongPayment_container"><?php echo __('Loading please wait ...'); ?></div>

    <?php echo javascript_tag(remote_function(array('update' => 'zongPayment_container',
                                                    'url' => url_for('ajax/zongPayment?msid=' . $member_subscription_id, true) . '?entrypointURL=' . $zongBonusEntryPointUrl))); ?>
<?php endif; ?>
