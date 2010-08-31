<?php echo form_tag('predefinedMessages/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('New Message', 'predefinedMessages/create') ?></td>
      </tr>
            <tr>
             <th></th>
             <th>Catalog</th>
             <th>Subject</th>
             <th>Sex</th>
             <th>Looking for</th>
            </tr>
    </thead>
        <tbody>
        <?php foreach ($messages as $message): ?>
        <tr rel="<?php echo url_for('predefinedMessages/edit?id=' . $message->getId()) ?>">
          <td class="marked"><?php echo checkbox_tag('marked[]', $message->getId(), null) ?></td>
          <td><?php echo $message->getCatalogue(); ?></td>
          <td><?php echo $message->getSubject() ?></td>
          <td><?php echo $message->getSex() ?></td>
          <td><?php echo $message->getLookingFor() ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
</table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected messages?') ?>
</form>