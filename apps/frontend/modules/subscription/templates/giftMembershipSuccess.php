<?php echo __('%USERNAME% uses Free Membership and %she_he% will only be able to reply to your message, but never write you a new one. You may nicely surprise %USERNAME% and buy %her_his%:<br /><br />', 
            array('%USERNAME%' => $member->getUsername(),
                 '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She',
                 '%her_his%' => ( $member->getSex() == 'M' ) ? 'his' : 'her'
            )); ?>
<?php echo form_tag('subscription/paymentGift') ?>
    <?php echo input_hidden_tag('profile', $member->getUsername()) ?>
    <input type="radio" id="gift_type_membership" name="gift_type" value="membership" checked="checked" /> <label for="gift_type_membership"><?php echo __('Gift Membership - 3 months full membership. (&pound;29.95)') ?></label><br />
    <!--  <input type="radio" id="gift_type_open_line" name="gift_type" value="open_line"/> <label for="gift_type_open_line"><?php echo __('Open Line - ability to to send you (and only you) unlimited new messages. (&pound;4.95).') ?> </label><br /> -->
    <br /><br />
    <?php echo link_to(__('Cancel and return to profile'), '@profile?username=' . $member->getUsername(), array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>
</form>