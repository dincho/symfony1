<?php use_helper('dtForm', 'Javascript', 'Object') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('geo/create', array('class' => 'form', 'id' => 'create_feature_form')) ?>
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo input_hidden_tag('ret_uri', $sf_request->getParameter('ret_uri')); ?>
    <?php endif; ?>
    <div class="legend">Add new geo feature</div>
    <fieldset class="form_fields">

        <label for="name">Name:</label>
        <?php echo input_tag('name', null, array('size' => 50, 'maxlength' => 100, 'class' => error_class('name', true))) ?><br />

        <label for="country">Country:</label>
        <?php echo select_tag('country', options_for_select($countries, null, array('include_blank' => true)), array('class' => error_class('country', true))) ?><br />

        <label for="adm1">ADM1</label>
        <?php echo select_tag('adm1', objects_for_select($adm1s, 'getId', 'getName', null, array('include_blank' => true)),
                            array('class' => error_class('adm1', true))) ?><br />

        <label for="adm2">ADM2</label>
        <?php echo select_tag('adm2', objects_for_select($adm2s, 'getId', 'getName', null, array('include_blank' => true)),
                            array('class' => error_class('adm2', true))) ?><br />

        <label for="dsg">DSG</label>
        <?php echo select_tag('dsg',
                            options_for_select(array('ADM1' => 'ADM1', 'ADM2' => 'ADM2', 'PPL' => 'PPL', ), 'PPL'),
                            array('class' => error_class('dsg', true))) ?><br />

        <label for="timezone">Timezone</label>
        <?php echo pr_select_timezone_tag('timezone', 'UTC'); ?><br />

        <label for="latitude">Latitude:</label>
        <?php echo input_tag('latitude', null, array('class' => error_class('latitude', true))) ?><br />

        <label for="longitude">Longitude:</label>
        <?php echo input_tag('longitude', null, array('class' => error_class('longitude', true))) ?><br />

        <label for="population">Population:</label>
        <?php echo input_tag('population', null, array('class' => error_class('population', true))) ?><br />

    </fieldset>

    <fieldset class="actions">
    <?php echo button_to('Cancel', 'geo/list?cancel=1')  .
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

<?php include_partial('geo_fields'); ?>
