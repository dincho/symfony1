<?php echo __('%USERNAME% uses Free Membership and %she_he% will only be able to reply to your message, but never write you a new one. You may nicely surprise %USERNAME% and buy %her_him%:<br /><br />', 
            array('%USERNAME%' => $member->getUsername(),
                 '%she_he%' => ( $member->getSex() == 'M' ) ? 'he' : 'she',
                 '%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her'
            )); ?>
<?php echo form_tag(sfConfig::get('app_paypal_url'), array('method' => 'post')) ?>
    <?php echo input_hidden_tag('cmd', '_s-xclick') , "\n" ?>
<input type="hidden" name="encrypted" value="
-----BEGIN PKCS7-----
<?php echo $encrypted . "\n" ?>
-----END PKCS7-----
">
    <input type="radio" id="gift_type_membership" name="gift_type" value="membership" checked="checked" />
    <label for="gift_type_membership"><?php echo __('Gift Membership - 3 months full membership.') ?></label><br /><br /><br />
    
    <br />
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>
    <?php echo link_to(__('Cancel'), '@profile?username=' . $member->getUsername(), array('class' => 'button')) ?>
</form>