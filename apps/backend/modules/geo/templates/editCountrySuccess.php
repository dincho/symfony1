<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('geo/editCountry', 'class=form') ?>
    <?php echo object_input_hidden_tag($geo, 'getId', 'class=hidden') ?>
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo input_hidden_tag('ret_uri', $sf_request->getParameter('ret_uri')); ?>
    <?php endif; ?>
    <div class="legend">Edit Country</div>
    <fieldset class="form_fields">

        <label for="name">Name:</label>
        <?php echo object_input_tag($geo, 'getName', array('size' => 50, 'maxlength' => 100, 'class' => error_class('name', true))) ?><br />

        <label for="iso_code">ISO code:</label>
        <?php echo object_input_tag($geo, 'getCountry', array('name' => 'iso_code', 'id' => 'iso_code', 'size' => 4, 'maxlength' => 4, 'class' => error_class('iso_code', true))) ?><br />

        <label for="timezone">Timezone</label>
        <?php echo pr_select_timezone_tag('timezone', $geo->getTimezone()); ?><br />
        <label>&nbsp;</label><?php echo checkbox_tag('set_subs_timezone', 1, null); ?>
        <var>Also set this timezone to all sub-features</var><br />

    </fieldset>

    <fieldset class="actions">
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo button_to('Cancel', base64_decode($sf_request->getParameter('ret_uri'))); ?>
    <?php else: ?>
        <?php echo button_to('Cancel', 'geo/list?cancel=1'); ?>
    <?php endif; ?>
    <?php echo button_to('Delete', 'geo/delete?id=' . $geo->getId() . '&ret_uri=' .$sf_request->getParameter('ret_uri'), 'confirm=Are you sure you want to delete this country?') .
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

<?php include_partial('geo_fields'); ?>
