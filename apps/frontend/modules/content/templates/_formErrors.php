<?php if ($sf_request->hasErrors()): ?>
<div id="msgs">
  <?php if(!$sf_flash->has('only_last_error')): ?>
  <?php foreach ($sf_request->getErrorNames() as $name): ?>
    <p class="msg_error" id="msg_error_<?php echo $name ?>"><?php echo __($sf_request->getError($name)) ?></p>
  <?php endforeach; ?>  
  <?php else: ?>
    <?php $errors = $sf_request->getErrors(ESC_RAW); ?>
    <p class="msg_error"><?php echo __(array_pop($errors)) ?></p>
  <?php endif; ?>
</div>
<?php endif; ?>