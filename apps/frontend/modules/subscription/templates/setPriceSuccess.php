<?php use_helper('dtForm'); ?>

<p><?php echo __('Set your own price instructions'); ?></p>

<?php echo form_tag('subscription/setPrice', array('method' => 'post', 'id' => 'subscription_set_prices')); ?>
    <fieldset>
        <label><?php echo __('Fee per %PERIOD% ' . pr_format_payment_period_type($subscription->getPeriodType()), array('%PERIOD%' => $subscription->getPeriod())) ?></label>
        <?php include_partial('prices_select', array('name' => 'amount', 'min_price' => $subscription->getAmount())); ?><br />

    </fieldset>

    <fieldset class="actions">
        <br />
        <?php echo submit_tag(__('Upgrade to Premium'), array('class' => 'button')); ?>
        <?php echo link_to(__('Cancel'), 'subscription/index', array('class' => 'button cancel')) ?>
    </fieldset>
    
</form>