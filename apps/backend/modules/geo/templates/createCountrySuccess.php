<?php use_helper('dtForm', 'Javascript', 'Object') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('geo/createCountry', array('class' => 'form', 'id' => 'create_feature_form')) ?>
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo input_hidden_tag('ret_uri', $sf_request->getParameter('ret_uri')); ?>
    <?php endif; ?>
    <div class="legend">Add new country</div>
    <fieldset class="form_fields">
        
        <label for="name">Name:</label>
        <?php echo input_tag('name', null, array('size' => 50, 'maxlength' => 100, 'class' => error_class('name', true))) ?><br />
        
        <label for="iso_code">ISO Code:</label>
        <?php echo input_tag('iso_code', null, array('size' => 4, 'maxlength' => 4, 'class' => error_class('iso_code', true))) ?><br />
                    
    </fieldset>
    
    <fieldset class="actions">
    <?php echo button_to('Cancel', 'geo/list?cancel=1')  . 
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

