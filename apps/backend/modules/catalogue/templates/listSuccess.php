<table class="zebra">
    <thead>
        <tr>
          <th>Language</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($catalogues as $catalogue): ?>
            <tr rel="<?php echo url_for('catalogue/edit?id=' . $catalogue->getCatId()) ?>">
                <td><?php echo $catalogue ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
