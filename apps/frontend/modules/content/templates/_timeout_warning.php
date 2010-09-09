<?php use_helper('Javascript'); ?>

<?php $minutes = 2; ?>
<?php $warning = __('Your session will expire in %MINUTES% minutes - Please, click something to avoid being timed out.', array('%MINUTES%' => $minutes));?>
<?php $timeout = (sfConfig::get('sf_timeout') - $minutes *60)*1000; ?>;

<script type="text/javascript" language="javascript">
//<![CDATA[
    Event.observe(window, 'load', function() {
      setTimeout(function() {      
        alert('<?php echo $warning; ?>');
      }, <?php echo $timeout; ?>); 
  
});
//]]>
</script>