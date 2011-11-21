<?php use_helper('Javascript'); ?>


<?php echo javascript_include_tag('messagebar') ?>

<?php $minutes = sfConfig::get('app_settings_timeout_warning'); ?>
<?php $warning = __('Your session will expire in %MINUTES% minutes - Please, click something to avoid being timed out.', array('%MINUTES%' => $minutes));?>
<?php $timeout = (sfConfig::get('sf_timeout') - $minutes *60)*1000; ?>

<script type="text/javascript" language="javascript">
//<![CDATA[
  var DISABLE_TIMEOUT_WARNING = false;
  
  Event.observe(window, 'load', function() {
    setTimeout(function() {
      if(!DISABLE_TIMEOUT_WARNING) 
      {
          alert('<?php echo $warning; ?>');
      }
    }, <?php echo $timeout; ?>) 
});
//]]>
</script>