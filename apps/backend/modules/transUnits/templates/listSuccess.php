<div class="filter_right"><?php echo button_to ('Add Translation Unit', 'transUnits/create') ?></div>
<table class="zebra">
    <thead>
    <tr>
      <th>Language</th>
      <th>Source</th>
      <th>Target</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($trans_units as $trans_unit): ?>
    <tr rel="<?php echo url_for('transUnits/edit?id=' . $trans_unit->getId()) ?>">
        <td><?php echo $trans_unit->getCatalogue()?></td>
        <td><?php echo Tools::truncate($trans_unit->getSource(), 110) ?></td>
        <td><?php echo Tools::truncate($trans_unit->getTarget(), 110) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
