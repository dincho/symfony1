<?php if ($sf_request->hasErrors()): ?>
<div class="form-errors">
  <h3>There are some errors that prevent the form to validate!</h3>
  <dl>
  <?php if(!$sf_flash->has('only_last_error')): ?>
  <?php foreach ($sf_data->get('sf_request')->getErrorNames() as $name): ?>
    <?php if(array_key_exists($name, $labels)): ?>
     <dt><?php echo $labels[$name] ?>:</dt>
    <?php else: ?>
     <dt><?php echo ucwords(str_replace('_', ' ', $name)); ?>:</dt>
    <?php endif; ?>
    <dd><?php echo $sf_data->get('sf_request')->getError($name) ?></dd>
  <?php endforeach; ?>  
  <?php else: ?>
    <?php $errors = $sf_request->getErrors(ESC_RAW); ?>
    <dt></dt>
    <dd><?php echo array_pop($errors) ?></dd>
  <?php endif; ?>
  </dl>
</div>
<?php endif; ?>
