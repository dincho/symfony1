<?php use_helper('Number') ?>
<?php echo __('You need to pay %AMOUNT%', array('%AMOUNT%' => format_currency($amount, 'GBP'))) ?><br /><br /><br />

<?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post')) ?>
    <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">
    <?php echo link_to(__('Cancel and return to profile'), '@profile?username=' . $username, array('class' => 'sec_link_small')) ?><br />  
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>
</form>
