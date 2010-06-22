<?php use_helper('xSortableTitle', 'Catalog') ?>

<table class="zebra">
    <thead>
        <tr>
         <th><?php echo sortable_title('Title', 'StaticPageI18n::title', $sort_namespace) ?></th>
         <th><?php echo sortable_title('URL Name', 'StaticPageI18n::link_name', $sort_namespace) ?></th>
         <th>Catalog</th>
        </tr>
    </thead>
        <tbody>
            <?php foreach ($pages as $page): ?>
            <tr>
              <td><?php echo $page->getTitle() ?></td>
              <td><?php echo $page->getStaticPage()->getSlug() ?>.html</td>
              <td class="languages">
                <?php echo select_catalog2url(null, 'staticPages/edit?id=' . $page->getId(), null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
