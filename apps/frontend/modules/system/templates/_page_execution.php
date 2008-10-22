<?php $total_time = sprintf('%.7f', (microtime(true) - sfConfig::get('pr_timer_start'))); ?>
<?php echo __('Page executed in %1% seconds', array('%1%' => $total_time)) ?>
