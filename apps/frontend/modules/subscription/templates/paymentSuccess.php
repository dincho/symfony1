<?php use_helper('Number', 'Javascript') ?>
<?php echo __('You need to pay %AMOUNT%', array('%AMOUNT%' => format_currency($amount, sfConfig::get('app_settings_currency_' . $sf_user->getCulture(), 'GBP')))) ?><br /><br /><br />

<?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post')) ?>
    <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">
    <?php echo link_to(__('Cancel and return to subscription'), 'subscription/index', array('class' => 'sec_link_small')) ?><br />
    <fieldset id="payment_buttons">
        <?php echo submit_tag(__('Subscribe With PayPal'), array('class' => 'button')) ?>
        <?php if( $zongAvailable ): ?>
            <?php echo button_to_function(__('Pay with Zong+'), 'show_zong_payment();', array('class' => 'button')); ?>
        <?php endif; ?>
    </fieldset>
</form>



<?php if( $zongAvailable ): ?>
    <div id="zongPayment_container" style="display: none;"><?php echo __('Loading please wait ...'); ?></div>

    <script type="text/javascript" charset="utf-8">
        function show_zong_payment()
        {
            $('payment_buttons').hide();
            $('zongPayment_container').show();
        
            <?php echo remote_function(array('update' => 'zongPayment_container', 'url' => 'ajax/zongPayment?msid=' . $member_subscription_id)); ?>
        }
    </script>
<?php endif; ?>