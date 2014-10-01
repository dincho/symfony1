<?php use_helper('Object', 'Validation', 'ObjectAdmin', 'I18N', 'Date') ?>

<ul>
    <?php foreach( $list as $key => $value ): ?>
      <li class="autoComplete" style="text-align: left;" id="<?php echo $key ?>"><?php echo $value ?></li>
    <?php endforeach; ?>
</ul>
