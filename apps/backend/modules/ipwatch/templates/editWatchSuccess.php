<?php use_helper('Object', 'dtForm', 'Javascript', 'General') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('ipwatch/editWatch') ?>
    <div class="legend">Edit IP</div>
    <?php echo object_input_hidden_tag($ipwatch, 'getId', 'class=hidden') ?>
        <fieldset class="form_fields">
            <label for="item">IP:</label>
            <?php echo input_tag('ip', long2ip($ipwatch->getIp()), error_class('ip')) ?>
        </fieldset>
  
    <fieldset class="actions">
    <?php echo button_to('Cancel', 'ipwatch/blacklist?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
