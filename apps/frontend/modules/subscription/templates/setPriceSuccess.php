<?php use_helper('dtForm'); ?>

<p><?php echo __('Set your own price instructions'); ?></p>

<?php echo form_tag('subscription/setPrice', array('method' => 'post', 'id' => 'subscription_set_prices')); ?>
    <fieldset>
        <label><?php echo __('First %PERIOD% ' . pr_format_payment_period_type($subscription->getTrial1PeriodType()), array('%PERIOD%' => $subscription->getTrial1Period()))?></label>
        <?php include_partial('prices_select', array('name' => 'a1', 'min_price' => $subscription->getTrial1Amount())); ?><br />
    
        <label><?php echo __('Next %PERIOD% ' . pr_format_payment_period_type($subscription->getTrial2PeriodType()), array('%PERIOD%' => $subscription->getTrial2Period())) ?></label>
        <?php include_partial('prices_select', array('name' => 'a2', 'min_price' => $subscription->getTrial2Amount())); ?><br />
    
        <label><?php echo __('Then every %PERIOD% ' . pr_format_payment_period_type($subscription->getPeriodType()), array('%PERIOD%' => $subscription->getPeriod())) ?></label>
        <?php include_partial('prices_select', array('name' => 'a3', 'min_price' => $subscription->getAmount())); ?><br />

    </fieldset>

    <fieldset class="actions">
        <?php echo link_to(__('Cancel and return to subscription'), 'subscription/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Upgrade to Premium'), array('class' => 'button')); ?>
    </fieldset>
    
</form>