 <div id="msgs">
   <?php if( $sf_flash->has('msg_info') ): ?>
     <p class="msg_info"><?php echo ( $sf_flash->has('msg_no_i18n') ) ? $sf_flash->get('msg_info', ESC_RAW) : __($sf_flash->get('msg_info', ESC_RAW)); ?></p>
   <?php endif; ?>
      
   <?php if( $sf_flash->has('msg_ok') ): ?>
     <p class="msg_ok"><?php echo ( $sf_flash->has('msg_no_i18n') ) ? $sf_flash->get('msg_ok', ESC_RAW) : __($sf_flash->get('msg_ok', ESC_RAW)); ?></p>
   <?php endif; ?>
   
   <?php if( $sf_flash->has('msg_warning') ): ?>
     <p class="msg_warning"><?php echo ( $sf_flash->has('msg_no_i18n') ) ? $sf_flash->get('msg_warning', ESC_RAW) : __($sf_flash->get('msg_warning', ESC_RAW)); ?></p>
   <?php endif; ?>
   
   <?php if( $sf_flash->has('msg_error') ): ?>
     <p class="msg_error"><?php echo ( $sf_flash->has('msg_no_i18n') ) ? $sf_flash->get('msg_error', ESC_RAW) : __($sf_flash->get('msg_error', ESC_RAW)); ?></p>
   <?php endif; ?>   
 </div>
