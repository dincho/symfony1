<table class="zebra">
    <thead>
        <tr>
         <th>Title</th>
         <th>URL Name</th>
        </tr>
    </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
            <tr rel="<?php echo url_for('staticPages/edit?id=' . $page->getId()) ?>">
              <td><?php echo $page->getTitle() ?></td>
              <td><?php echo $page->getSlug() ?>.html</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
