<?php use_helper('Number') ?>
<?php echo __('You need to pay %PRICE%', array('%PRICE%' => format_currency($price, 'GBP'))) ?><br /><br /><br />
<?php echo form_tag('subscription/payment?subscription_id=' . $subscription_id) ?>
    <?php echo link_to(__('Cancel and return to subscription'), 'subscription/index', array('class' => 'sec_link')) ?><br />
    <?php echo submit_tag(__('Pay Now'), array('class' => 'button')) ?>
</form>
