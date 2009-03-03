<?php use_helper('Javascript') ?>
<?php echo __('Select the areas you want to find members in. To view a detailed map, roll-over the ares names..') ?><br /><br />

<?php slot('header_title') ?>
    <?php echo __('%COUNTRY% areas', array('%COUNTRY%' => format_country($sf_request->getParameter('country'))))?>
<?php end_slot(); ?>

<div id="areas_map"></div>

<form action="<?php echo url_for('search/selectAreas')?>" id="areas" name="areas_form" method="post">
    <?php echo input_hidden_tag('country', $sf_request->getParameter('country'), array('id' => 'country')) ?>
    <?php echo input_hidden_tag('polish_cities', $sf_request->getParameter('polish_cities')) ?>
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?><br /><br />
    <?php echo link_to_function(__('Select All'), 'SC_select_all(document.forms.areas_form.elements["areas[]"])', array('class' => 'sec_link')) ?>
    <fieldset>
        <?php foreach ($areas as $area): ?>
            <?php echo checkbox_tag('areas[]', $area->getId(), (in_array($area->getId(), $sf_data->getRaw('selected_areas')) || $sf_request->hasParameter('select_all')) ) ?>
            <label for="areas_<?php echo $area->getId() ?>"><?php echo link_to_function($area->getTitle(), 
                        'void()', 
                        array('class' => 'slf', 
                              'onmouseover' => 'show_area("'. $area->getTitle().'")',
                              'onmouseout' => "map.removeOverlay(g_marker)"
                        )) ?></label><br />
        <?php endforeach; ?>
    </fieldset>
    
    <br class="clear" />
    <?php echo submit_tag(__('Save'), array('class' => 'button', 'style' => 'margin: 5px;')) ?><br />
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?>
</form>
<br class="clear" />

<script>
var country = document.getElementById('country').value;
init_area_map();
</script>