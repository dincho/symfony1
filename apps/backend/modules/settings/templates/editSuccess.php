<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('settings/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($setting, 'getName', array('class' => 'hidden', )) ?>
  <?php echo object_input_hidden_tag($setting, 'getCatId', array('class' => 'hidden', )) ?>

  <div class="legend">Editing: <?php echo $setting->getDescription() ?></div>
  <fieldset class="form_fields">
    <label for="value">Value:</label>
    <?php echo object_input_tag($setting, 'getValue') ?>

  </fieldset>
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'settings/list?cat_id=' . $setting->getCatId())  ?>
    <?php echo submit_tag('Save', 'class=button') ?>
    <?php echo submit_tag('Save for all catalogs', array('name' => 'allCats', 'class' => 'button')) ?>
  </fieldset>
  <br/>
  <fieldset>
      <table>
        <tr>
          <th>Catalog</th>
          <th>Value</th>
        </tr>
        <?php foreach ($settings as $set): ?>
          <tr>
            <td><?php echo $set->getCatalogue()->getDomain(); ?></td>
            <td><?php echo $set->getValue()?></td>
          </tr>
        <?php endforeach ?>
      </table>
  </fieldset>
</form>
