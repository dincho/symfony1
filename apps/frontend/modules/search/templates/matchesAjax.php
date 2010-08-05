<?php echo use_helper('Javascript', 'updateElements') ?>

<?php slot('first_update') ?> 
  <?php if( $sf_data->get('sf_flash')->has('msg_error') || 
            $sf_data->get('sf_flash')->has('msg_warning') || 
            $sf_data->get('sf_flash')->has('msg_ok') || 
            $sf_data->get('sf_flash')->has('msg_info') ): ?>
      <?php include_partial('content/messages'); ?>
  <?php endif; ?>
<?php end_slot() ?>

<?php slot('second_update') ?>  
  <?php if($has_criteria): ?>
      <?php if( isset($pager) && $pager->getNbResults() > 0 ): ?>
          <?php include_partial('results', array('pager' => $pager, 'route' => 'search/matches')); ?>
      <?php else: ?>
          <div class="msg_error text-center"><?php echo __('No results found - matches') ?></div>        
      <?php endif; ?>
  
  <?php else: ?>
      <?php echo __('To use Matches you obviously need to set up your search criteria first.') ?>    
  <?php endif; ?>
<?php end_slot() ?> 


<?php echo update_elements_function( array(
  'msg_container'  => 'first_update',
  'match_results' => 'second_update',
)) ?>

