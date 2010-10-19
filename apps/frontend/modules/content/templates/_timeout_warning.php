<?php use_helper('Javascript'); ?>


<?php echo javascript_include_tag('messagebar') ?>

<?php $minutes = sfConfig::get('app_settings_timeout_warning'); ?>
<?php $warning = __('Your session will expire in %MINUTES% minutes - Please, click something to avoid being timed out.', array('%MINUTES%' => $minutes));?>

<script type="text/javascript" language="javascript">
//<![CDATA[
  
  Event.observe(window, 'load', function() {
    setTimeout(function() {      
      alert('<?php echo $warning; ?>');
    }, <?php echo $timeout; ?>); 

});
//]]>
</script>