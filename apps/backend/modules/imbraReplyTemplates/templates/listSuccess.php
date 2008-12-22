<?php echo form_tag('imbraReplyTemplates/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('New Template', 'imbraReplyTemplates/create') ?></td>
      </tr>
			<tr>
			 <th></th>
			 <th>Created</th>
			 <th>Admin User</th>
			 <th>Name</th>
			</tr>
    </thead>
		<tbody>
		<?php foreach ($imbra_reply_templates as $imbra_reply_template): ?>
		<tr rel="<?php echo url_for('imbraReplyTemplates/edit?id=' . $imbra_reply_template->getId()) ?>">
		  <td class="marked"><?php echo checkbox_tag('marked[]', $imbra_reply_template->getId(), null) ?></td>
		  <td><?php echo $imbra_reply_template->getCreatedAt('m/d/Y') ?></td>
		  <td><?php echo $imbra_reply_template->getUser()->getUsername() ?></td>
		  <td><?php echo $imbra_reply_template->getTitle() ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected templates?') ?>
</form>