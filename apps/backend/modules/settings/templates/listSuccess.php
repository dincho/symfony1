<?php use_helper('Javascript', 'dtBoolValue') ?>

<table class="zebra">
    <thead>
        <tr>
            <th>Description</th>
            <th>Value</th>
        </tr>
    </thead>
    
<?php foreach ($settings as $setting): ?>
    <tr rel="<?php echo url_for('settings/edit?id=' . $setting->getId()) ?>">
        <td><?php echo $setting->getDescription(); ?></td>
        <td>
            <?php if( $setting->getVarType() == 'bool'): ?>
                <?php echo boolValue($setting->getValue()) ?>
            <?php else: ?>
                <?php echo $setting->getValue(); ?>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
