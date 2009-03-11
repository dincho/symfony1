<?php use_helper('xSortableTitle') ?>

<table class="zebra">
    <thead>
        <tr>
         <th><?php echo sortable_title('Title', 'StaticPageI18n::title', $sort_namespace) ?></th>
         <th><?php echo sortable_title('URL Name', 'StaticPageI18n::link_name', $sort_namespace) ?></th>
         <th>Languages</th>
        </tr>
    </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
            <tr rel="<?php echo url_for('staticPages/edit?id=' . $page->getId()) ?>">
              <td><?php echo $page->getTitle() ?></td>
              <td><?php echo $page->getSlug() ?>.html</td>
              <td class="languages">
                <?php echo link_to(image_tag('flags/us.gif'), 'staticPages/edit?culture=en&id=' . $page->getId()) ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'staticPages/edit?culture=pl&id=' . $page->getId()) ?>
              </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
