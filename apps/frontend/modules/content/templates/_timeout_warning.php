<?php use_helper('Javascript'); ?>


<?php echo javascript_include_tag('messagebar') ?>

<?php $minutes = sfConfig::get('app_settings_timeout_warning'); ?>
<?php $warning = __('Your session will expire in %MINUTES% minutes - Please, click something to avoid being timed out.', array('%MINUTES%' => $minutes));?>
<?php $timeout = (sfConfig::get('sf_timeout') - $minutes *60)*1000; ?>

<script type="text/javascript" language="javascript">
//<![CDATA[
  
  Event.observe(window, 'load', function() {
      // do not show an alert on page 'photos.html' in case of Mac OS X and ff3 or safari      
     if( (/Firefox/.test( navigator.userAgent ) || (/Safari/.test( navigator.userAgent ) && !/Chrome/.test( navigator.userAgent )))&& 
        /Mac OS X/.test( navigator.userAgent ) &&
        /photos.html/.test( window.location.href ))
     {
        return;
     }    
    
    setTimeout(function() {      
      alert('<?php echo $warning; ?>');
    }, <?php echo $timeout; ?>) 
});
//]]>
</script>