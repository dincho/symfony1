<?php use_helper('Javascript') ?>
<?php include_partial('content/messages'); ?>
<?php $title_req = __('You already requested access to %USERNAME%\'s private photos.', array('%USERNAME%' => $profile->getUsername())); ?>
<?php echo javascript_tag('$("private_photos").update("'.$title_req.'");' ); ?>;

