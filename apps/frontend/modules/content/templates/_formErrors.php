<?php use_helper('Javascript'); ?>
<?php if ($sf_request->hasErrors()): ?>
  <div id="msgs">
    <?php if(!$sf_flash->has('only_last_error')): ?>

      <?php if( $sf_flash->has('only_unique_errors') ): ?>
        <?php $errors = array_unique($sf_request->getErrors(ESC_RAW)); ?>
        <?php foreach ($errors as $name => $value): ?>
          <p class="msg_error" id="msg_error_<?php echo $name ?>"><?php echo $sf_request->getError($name, ESC_RAW) ?></p>
        <?php endforeach; ?>
      <?php else:?>
        <?php foreach ($sf_request->getErrorNames() as $name): ?>
          <p class="msg_error" id="msg_error_<?php echo $name ?>"><?php echo $sf_request->getError($name, ESC_RAW) ?></p>
        <?php endforeach; ?>
      <?php endif; ?>

    <?php else: ?>
      <?php $errors = $sf_request->getErrors(ESC_RAW); ?>
      <p class="msg_error"><?php echo __(array_pop($errors)) ?></p>
    <?php endif; ?>
  </div>
<?php endif; ?>
