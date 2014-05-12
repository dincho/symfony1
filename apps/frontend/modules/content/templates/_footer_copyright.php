<?php $total_time = sprintf('%.7f', (microtime(true) - sfConfig::get('pr_timer_start'))); ?>
<div class="footer_footer"><?php echo __('Footer copyright', array('%VERSION%' => sfConfig::get('app_version'), '%PAGE_EXECUTION_TIME%' => $total_time)); ?></div>
