<?php use_helper('Javascript'); ?>


<?php echo javascript_include_tag('messagebar') ?>

<?php $minutes = sfConfig::get('app_settings_timeout_warning'); ?>
<?php $warning = __('Your session will expire in %MINUTES% minutes - Please, click something to avoid being timed out.', array('%MINUTES%' => $minutes));?>
<?php $timeout = (sfConfig::get('sf_timeout') - $minutes *60)*1000; ?>

<script type="text/javascript" language="javascript">
//<![CDATA[

  var minuntes_left = <?php echo (sfConfig::get('sf_timeout'))/60; ?> +1;  
  var warning = <?php echo "'".__('Please save this page within %TIMEOUT% minutes or your changes will be lost.')."'"; ?>  ;
  
  function countDown()
  {
    minuntes_left--;
    messagebar_message(warning.replace('%TIMEOUT%', minuntes_left.toString())); 
  
    TO = setTimeout( countDown, 1000 * 60 );
    if(minuntes_left == 0)
    {
      clearTimeout(TO);
    }
  }
  
  Event.observe(window, 'load', function() {
    setTimeout(function() {      
      alert('<?php echo $warning; ?>');
    }, <?php echo $timeout; ?>); 

  countDown();
});
//]]>
</script>