<?php use_helper('dtForm'); ?>

<p>
    <?php echo __('If you have VIP or Premium, you can give a VIP or Premium to %LIMIT% of your friends within %PERIOD% days of your last payment',
        array('%LIMIT%' => sfConfig::get('app_gifts_friends_limit', 2), '%PERIOD%' => sfConfig::get('app_gifts_send_period_days', 7))); ?>
</p>
<?php if ($allowedGifts > 0): ?>
    <?php echo form_tag('@send_gift', array('method' => 'post')) ?>
    <?php echo pr_label_for('email', __("Recipient's email") . '<span style="color:red;">*</span>') ?>
    <?php echo input_tag('email') ?><br />
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
    </form>
<?php endif; ?>
