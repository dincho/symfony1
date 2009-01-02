<?php if( $sf_data->get('sf_flash')->has('msg_error') || $sf_data->get('sf_flash')->has('msg_warning') || $sf_data->get('sf_flash')->has('msg_ok') || $sf_data->get('sf_flash')->has('msg_info') ): ?>
  <div id="msgs">
    <?php if( $sf_data->get('sf_flash')->has('msg_error') ): ?>
      <p class="msg_error"><?php echo __($sf_data->getRaw('sf_flash')->get('msg_error')); ?></p>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_warning') ): ?>
      <p class="msg_warning"><?php echo __($sf_data->getRaw('sf_flash')->get('msg_warning')); ?></p>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_ok') ): ?>
      <p class="msg_ok"><?php echo __($sf_data->getRaw('sf_flash')->get('msg_ok')); ?></p>
    <?php endif; ?>
    <?php if( $sf_data->get('sf_flash')->has('msg_info') ): ?>
      <p class="msg_info"><?php echo __($sf_data->getRaw('sf_flash')->get('msg_info')); ?></p>
    <?php endif; ?>
  </div>
<?php endif; ?>
