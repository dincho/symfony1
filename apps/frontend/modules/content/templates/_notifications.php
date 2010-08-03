<?php use_helper('Javascript'); ?>

<?php $ajax_request = remote_function(array('success' => 'parse_notifications(request, '. sfConfig::get('app_settings_member_notification_lifetime', 7000) .')', 
                                 'url' => 'ajax/notifications',
                                )); ?>
                                
<script type="text/javascript" language="javascript">
//<![CDATA[
Event.observe(window, 'load', function() {


  <?php echo $ajax_request; ?>
  
  setTimeout(function() {
    new PeriodicalExecuter(function() {<?php echo $ajax_request; ?>}, 60);
  }, 1000);
  
});

//]]>
</script>



