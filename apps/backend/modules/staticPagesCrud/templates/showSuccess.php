<?php
// auto-generated by sfPropelCrud
// date: 2008/07/17 15:31:12
?>
<table>
<tbody>
<tr>
<th>Id: </th>
<td><?php echo $static_page->getId() ?></td>
</tr>
<tr>
<th>Slug: </th>
<td><?php echo $static_page->getSlug() ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo link_to('edit', 'staticPagesCrud/edit?id='.$static_page->getId()) ?>
&nbsp;<?php echo link_to('list', 'staticPagesCrud/list') ?>
