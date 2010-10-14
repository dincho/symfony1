<?php use_helper('Javascript', 'dtBoolValue') ?>

<table class="zebra">
    <thead>
        <tr>
            <th>Description</th>
            <th>Value</th>
        </tr>
    </thead>
    
<?php foreach ($settings as $setting): ?>
    <tr rel="<?php echo url_for('settings/edit?name=' . $setting->getName() . '&cat_id=' . $setting->getCatId()) ?>">
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
<?php include_component('content', 'bottomMenu', array('url' => 'settings/list'))?>