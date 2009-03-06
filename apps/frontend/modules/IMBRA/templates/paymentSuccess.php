<?php use_helper('Number') ?>

<?php if( is_null($member->getImbraPayment()) ):?>
	<?php echo __('IMBRA Payment Content', array('%AMOUNT%' => $amount)) ?>
	    
<?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post')) ?>
    <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">

    <a href="javascript:window.history.go(-1)" class="sec_link_small"><?php echo __('Cancel and go back to previous page')?></a><br />  
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>

</form>
<?php elseif( $member->getImbraPayment() == 'completed'): ?>
    <?php echo __('You already have IMBRA payment.') ?>
<?php elseif( $member->getImbraPayment() == 'pending'): ?>
    <?php echo __('Your IMBRA payment is pending.') ?>
<?php endif; ?>


