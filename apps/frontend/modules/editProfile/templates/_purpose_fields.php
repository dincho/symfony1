<?php echo pr_label_for('purpose', __('Purpose') . '<span style="color:red;">*</span>') ?>

<?php foreach( _purpose_array($member->getOrientationKey()) as $key => $value ): ?>
  <?php echo checkbox_tag('purpose[]', $key, fillIn('purpose['.$key.']', 'r', false, in_array($key, $member->getPurpose(ESC_RAW))), array('class' => 'checkbox') ); ?>
  <var><?php echo format_purpose($key, $member->getOrientationKey()); ?></var><br />
<?php endforeach; ?>
