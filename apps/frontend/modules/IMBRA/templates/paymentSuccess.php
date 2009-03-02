<?php use_helper('Number') ?>

<?php if( is_null($member->getImbraPayment()) ):?>
	<?php echo __('The payment is for review and handling of you application and includes checking your record in national and state sex offenders registers and translation of your application into Polish. According to our <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a>, even if we reject your application for whatever reason, your payment will not be refunded.<br /><br />
	    Please pay and continue only if agree to these and other terms expressed in our <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a>.<br />') ?>
	    
<?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post')) ?>
    <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">

    <br /><?php echo __('By clicking Pay Now button, I agree to all the terms and to pay a non-refundable fee of &pound;%AMOUNT%.', array('%AMOUNT%' => $amount))?><br /><br /><br />

    <a href="javascript:window.history.go(-1)" class="sec_link_small"><?php echo __('Cancel and go back to previous page')?></a><br />  
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>

</form>
<?php elseif( $member->getImbraPayment() == 'completed'): ?>
    <?php echo __('You already have IMBRA payment.') ?>
<?php elseif( $member->getImbraPayment() == 'pending'): ?>
    <?php echo __('Your IMBRA payment is pending.') ?>
<?php endif; ?>


