<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('geo/batchEdit', 'class=form') ?>

    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo input_hidden_tag('ret_uri', $sf_request->getParameter('ret_uri')); ?>
    <?php endif; ?>
    
    <?php echo input_hidden_tag('marked', (is_array($sf_request->getParameter('marked'))) ? implode(',', $sf_request->getParameter('marked')) : $sf_request->getParameter('marked') ); ?>
    
    <div class="legend">Batch Edit Geo Feature</div>
    <fieldset class="form_fields">
        
        <label for="country">Country:</label>
        <?php echo checkbox_tag('set_country'); ?>
        <?php echo pr_select_country_tag('country', null, array('class' => error_class('country', true), 'include_custom' => str_repeat('-', 30))) ?><br />
        
        <label for="adm1">ADM1</label>
        <?php echo checkbox_tag('set_adm1'); ?>
        <?php echo select_tag('adm1', 
                            objects_for_select($adm1s, 'getName', 'getName', null, array('include_custom' => str_repeat('-', 30))), 
                            array('class' => error_class('adm1', true))) ?><br />
                            
        <label for="adm2">ADM2</label>
        <?php echo checkbox_tag('set_adm2'); ?>
        <?php echo select_tag('adm2', 
                            objects_for_select($adm2s, 'getName', 'getName', null, array('include_custom' => str_repeat('-', 30))), 
                            array('class' => error_class('adm2', true))) ?><br />
                            
        <label for="dsg">DSG</label>
        <?php echo checkbox_tag('set_dsg'); ?>
        <?php echo select_tag('dsg', 
                            options_for_select(array('ADM1' => 'ADM1', 'ADM2' => 'ADM2', 'PPL' => 'PPL', ), null), 
                            array('class' => error_class('dsg', true))) ?><br />                             

                
    </fieldset>
    
    <fieldset class="actions">
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo button_to('Cancel', base64_decode($sf_request->getParameter('ret_uri'))); ?>
    <?php else: ?>
        <?php echo button_to('Cancel', 'geo/list?cancel=1'); ?>
    <?php endif; ?>
    <?php echo submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

<?php include_partial('geo_fields'); ?>