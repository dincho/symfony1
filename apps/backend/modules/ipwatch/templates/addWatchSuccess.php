<?php use_helper('Object', 'dtForm', 'Javascript', 'General') ?>
<?php include_component('system', 'formErrors') ?>


<?php echo form_tag('ipwatch/addWatch') ?>
<div class="legend">New IP Watch</div>
    <fieldset class="form_fields">
        <label for="ip">IP:</label>
        <?php echo input_tag('ip', long2ip($sf_request->getParameter('ip')), error_class('ip')) ?>
    </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'ipwatch/blacklist?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
