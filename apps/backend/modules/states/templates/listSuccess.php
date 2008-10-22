<?php use_helper('I18N') ?>
<?php echo form_tag('states/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="3"><?php echo button_to ('Add State', 'states/create') ?></td>
      </tr>
      <tr>
        <th></th>
        <th>Country</th>
        <th>Title</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($states as $state): ?>
      <tr rel="<?php echo url_for('states/edit?id=' . $state->getId()) ?>" >
        <td class="marked"><?php echo checkbox_tag('marked[]', $state->getId(), null) ?></td>
        <td><?php echo format_country($state->getCountry()); ?></td>
        <td><?php echo $state->getTitle() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected states?') ?>
</form>

