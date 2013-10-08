<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php if( $pager->hasResults() ): ?>
    <div id="profile_pager">
        <?php echo link_to_unless(is_null($pager->getPrevious()), '&lt;&lt;&nbsp;Previous', 'geo/edit?id=' . $pager->getPrevious(), array()) ?>
        <?php echo link_to("Back to List", 'geo/list', array('class' => 'sec_link')) ?>
        <?php echo link_to_unless(is_null($pager->getNext()), 'Next&nbsp;&gt;&gt;', 'geo/edit?id=' . $pager->getNext(), array()) ?>
    </div>
    <br />
<?php endif; ?>

<?php echo form_tag('geo/edit', 'class=form') ?>
    <?php echo object_input_hidden_tag($geo, 'getId', 'class=hidden') ?>
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo input_hidden_tag('ret_uri', $sf_request->getParameter('ret_uri')); ?>
    <?php endif; ?>
    <div class="legend">Edit Geo Feature</div>
    <fieldset class="form_fields">
        
        <label for="name">Name:</label>
        <?php echo object_input_tag($geo, 'getName', array('size' => 50, 'maxlength' => 100, 'class' => error_class('name', true))) ?>
        <?php echo link_to('Google Search', 'http://google.com/search', 
                                    array( 'query_string' => 'q=' . urlencode($geo_string),
                                           'target' => '_blank',
                                           'style' => 'float: left;')); ?><br />

        <label for="country">Country:</label>
        <?php echo pr_select_country_tag('country', $geo->getCountry(), array('class' => error_class('country', true))) ?><br />
        
        <label for="adm1">ADM1</label>
        <?php echo select_tag('adm1', 
                            objects_for_select($adm1s, 'getId', 'getName', $geo->getAdm1Id(), array('include_custom' => str_repeat('-', 30))), 
                            array('class' => error_class('adm1', true))) ?><br />
                            
        <label for="adm2">ADM2</label>
        <?php echo select_tag('adm2', 
                            objects_for_select($adm2s, 'getId', 'getName', $geo->getAdm2Id(), array('include_custom' => str_repeat('-', 30))), 
                            array('class' => error_class('adm2', true))) ?><br />
                            
        <label for="dsg">DSG</label>
        <?php echo select_tag('dsg', 
                            options_for_select(array('ADM1' => 'ADM1', 'ADM2' => 'ADM2', 'PPL' => 'PPL', ), $geo->getDSG()), 
                            array('class' => error_class('dsg', true))) ?><br />                             

        <label for="timezone">Timezone</label>
        <?php echo pr_select_timezone_tag('timezone', $geo->getTimezone()); ?><br />
        <label>&nbsp;</label><?php echo checkbox_tag('set_subs_timezone', 1, null, array('disabled' => ($geo->getDSG() == 'PPL') )); ?>
        <var>Also set this timezone to all sub-features</var><br />
        
        <label for="latitude">Laatitude:</label>
        <?php echo object_input_tag($geo, 'getLatitude', null, null, array('class' => error_class('latitude', true))) ?><br />
        
        <label for="longitude">Longitude:</label>
        <?php echo object_input_tag($geo, 'getLongitude', null, null, array('class' => error_class('longitude', true))) ?><br />
        
        <label for="population">Population:</label>
        <?php echo object_input_tag($geo, 'getPopulation', null, null, array('class' => error_class('population', true))) ?><br />

                
    </fieldset>
    
    <fieldset class="actions">
    <?php if( $sf_request->hasParameter('ret_uri') ): ?>
        <?php echo button_to('Cancel', base64_decode($sf_request->getParameter('ret_uri'))); ?>
    <?php else: ?>
        <?php echo button_to('Cancel', 'geo/list?cancel=1'); ?>
    <?php endif; ?>
    <?php echo button_to('Delete', 'geo/delete?id=' . $geo->getId() . '&ret_uri=' .$sf_request->getParameter('ret_uri'), 'confirm=Are you sure you want to delete this geo feature?') . 
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

<?php include_partial('geo_fields'); ?>