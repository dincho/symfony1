<?php use_helper('I18N') ?>
<table class="zebra">
    <thead>
        <tr>
         <th>Home Page</th>
         <th>Description</th>
         <th>Catalog</th>
        </tr>
    </thead>
        <tbody>
            <?php $i=1;foreach ($trans as $tran): ?>
            <tr rel="<?php echo url_for('content/homepage?cat_id=' . $tran->getCatalogue()->getCatId()) ?>">
              <td><?php echo $i++; ?></td>
              <td><?php echo $tran->getTarget() ?></td>
              <td><?php echo $tran->getCatalogue() ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
