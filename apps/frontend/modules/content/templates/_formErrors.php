<?php if (!$sf_flash->has('dont_show_errors') && $sf_request->hasErrors()): ?>
<div id="msgs">
  <?php foreach ($sf_data->get('sf_request')->getErrorNames() as $name): ?>
    <p class="msg_error">
        <?php echo $sf_data->get('sf_request')->getError($name) ?>
    </p>
  <?php endforeach; ?>  
</div>
<?php endif; ?>