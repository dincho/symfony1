<?php use_helper('I18N') ?>
<table class="zebra">
    <thead>
        <tr>
         <th>Home Page</th>
         <th>Description</th>
         <th>Language</th>
        </tr>
    </thead>
        <tbody>
            <?php $i=1;foreach ($trans as $tran): ?>
            <tr rel="<?php echo url_for('content/homepage?culture=' . $tran->getCatalogue()->getTargetLang()) ?>">
              <td><?php echo $i++; ?></td>
              <td><?php echo $tran->getTarget() ?></td>
              <td><?php echo format_language($tran->getCatalogue()->getTargetLang()) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
