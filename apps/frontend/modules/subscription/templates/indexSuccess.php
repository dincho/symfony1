<?php use_helper('Number', 'dtForm') ?>
<?php echo __('Subscription page headline') ?>

<?php $better_subscription_flag = false; ?>

<?php echo form_tag('subscription/index', array('id' => 'subscription')) ?>
    <fieldset style="width: 90%;">
        <div class="column left">
            <div class="subscription_features">
              <span class="top">&nbsp;</span>
              <span class="type"><?php echo __('Respond to messages') ?></span><br />
              <span class="type"><?php echo __('Send messages') ?></span><br />
              <span class="type"><?php echo __('See who\'s viewed your profile') ?></span><br />
              <span class="type"><?php echo __('Contact Online Assistant') ?></span><br />
              <span class="type"><?php echo __('Private Dating') ?></span><br />
              <span class="type"><?php echo __('Send Gifts') ?></span><br />
              <span class="type"><?php echo __('Hide visitor\'s counter') ?></span><br />
              <span class="type">
                  <?php echo __('Subscription Price:'); ?>
              </span><br />
              <span class="select"><?php echo __('Select Membership') ?>&nbsp;</span>
            </div>
        </div>
        <?php $columnIdx = 1; ?>
        <?php foreach ($subscriptions as $subscription): ?>
            <div class="column column_<?php echo $columnIdx ?>">
                <?php if ($columnIdx++ == 3): ?>
                  <div class="upgrade_header">
                      <div><?php echo __('Upgrade to %SUBSCRIPTION_TITLE% account!', array('%SUBSCRIPTION_TITLE%' => $subscription->getTitle())); ?></div>
                  </div>
                <?php endif; ?>
                <div class="subscription_features">
                  <span class="top"><?php echo __($subscription->getTitle()) ?></span>
                  <span class="check"><?php echo ($subscription->getCanReplyMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanSendMessages()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanSeeViewed()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanContactAssistant()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getPrivateDating()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanSendGift()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check"><?php echo ($subscription->getCanHideVisitorCounter()) ? image_tag('check_mark.gif') : '&nbsp;'?></span>
                  <span class="check">
                      <?php $price = format_currency($subscription->getAmount(), $subscription->getCurrency()); ?>
                      <?php $period_type = pr_format_payment_period_type($subscription->getPeriodType()); ?>
                      <?php echo __('%PRICE% / %PERIOD% %PERIOD_TYPE%', array('%PRICE%' => $price, '%PERIOD%' => $subscription->getPeriod(), '%PERIOD_TYPE%' => $period_type)); ?>
                  </span>
                  <span class="select">
                    <?php echo button_to(__('Upgrade to %SUBSCRIPTION_TITLE%',  array('%SUBSCRIPTION_TITLE%' => $subscription->getTitle())),
                      'subscription/payment?sid=' . $subscription->getSubscriptionId(), array('class' => 'button')); ?>
                  </span>
                </div>
            </div>
        <?php endforeach; ?>
    </fieldset>
    <br class="clear" />
    <br /><br /><br /><?php echo __('Please allow up at 48 hours for the changes to take effect.') ?><br />
    <?php echo __('Prices and avialable features subject to changes without notice. Please read <a href="%URL_FOR_TERMS%" class="sec_link">Terms of Use</a> for details.') ?>
    <br /><br /><br />

    <?php echo link_to(__('Cancel'), 'dashboard/index', array('class' => 'button cancel')) ?><br />
</form>
<br /><br /><br class="clear" />

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
