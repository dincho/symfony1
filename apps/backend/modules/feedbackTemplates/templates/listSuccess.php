<?php echo form_tag('feedbackTemplates/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('New Template', 'feedbackTemplates/create') ?></td>
      </tr>
			<tr>
			 <th></th>
			 <th>Name</th>
			 <th>Tags</th>
			</tr>
    </thead>
		<tbody>
		<?php foreach ($templates as $template): ?>
		<tr rel="<?php echo url_for('feedbackTemplates/edit?id=' . $template->getId()) ?>">
		  <td class="marked"><?php echo checkbox_tag('marked[]', $template->getId(), null) ?></td>
		  <td><?php echo $template->getName() ?></td>
		  <td><?php echo $template->getTags() ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected templates?') ?>
</form>