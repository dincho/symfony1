<?php use_helper('Number', 'Javascript') ?>
<?php echo __('You need to pay %AMOUNT%', array('%AMOUNT%' => format_currency($amount, $currency))) ?><br /><br /><br />

<?php if ($paypalAvailable): ?>
    <?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post', 'id' => 'paypal_form', )) ?>
        <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">
        <?php echo submit_tag(__('Subscribe With PayPal'), array('class' => 'button', 'id' => 'paypal_button')) ?>
    </form>
    <?php echo __('Payment description - paypal'); ?>
<?php endif; ?>

<?php if ($zongAvailable): ?>
    <?php echo button_to_function(__('Pay with Zong+'), 'show_zong_payment();', array('class' => 'button', 'id' => 'zong_button')); ?>
    <?php echo __('Payment description - zong'); ?>

    <div id="zongPayment_container" style="display: none;"><?php echo __('Loading please wait ...'); ?></div>

    <script type="text/javascript" charset="utf-8">
        function show_zong_payment()
        {
            $('paypal_button').hide();
            $('zong_button').hide();
            $('zongPayment_container').show();

            <?php echo remote_function(array('update' => 'zongPayment_container', 'url' => 'ajax/zongPayment?msid=' . $memberSubscriptionId)); ?>
        }
    </script>
<?php endif; ?>

<?php if ($dotpayAvailable): ?>
    <?php echo form_tag($sf_data->getRaw('dotpayURL'), array('method' => 'post', 'id' => 'dotpay_form')) ?>
        <?php echo submit_tag(__('Pay with DotPay'), array('class' => 'button', 'id' => 'dotpay_button')); ?>
    </form>
    <?php echo __('Payment description - dotpay'); ?>
<?php endif; ?>

<?php if ($dotpaySmsAvailable): ?>
    <?php echo __('Payment description - dotpay sms', array(
        '%SMS_TEXT%' => $smsText,
        '%NUMBER%' => sfConfig::get('app_dotpay_sms_number')
    )); ?>
<?php endif; ?>

<br />
<?php echo link_to(__('Cancel'), 'subscription/index', array('class' => 'button cancel')) ?>
