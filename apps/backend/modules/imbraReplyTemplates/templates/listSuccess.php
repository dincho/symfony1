<?php echo form_tag('imbraReplyTemplates/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('New Template', 'imbraReplyTemplates/create') ?></td>
      </tr>
			<tr>
			 <th></th>
			 <th>Title</th>
			 <th>Subject</th>
			 <th>Body</th>
			</tr>
    </thead>
		<tbody>
		<?php foreach ($imbra_reply_templates as $imbra_reply_template): ?>
		<tr rel="<?php echo url_for('imbraReplyTemplates/edit?id=' . $imbra_reply_template->getId()) ?>">
		  <td class="marked"><?php echo checkbox_tag('marked[]', $imbra_reply_template->getId(), null) ?></td>
		  <td><?php echo $imbra_reply_template->getTitle() ?></td>
		  <td><?php echo Tools::truncate($imbra_reply_template->getSubject(), 50) ?></td>
		  <td><?php echo Tools::truncate($imbra_reply_template->getBody(), 50) ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected templates?') ?>
</form>