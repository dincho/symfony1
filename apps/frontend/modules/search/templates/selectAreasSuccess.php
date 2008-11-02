<?php use_helper('Javascript') ?>
<?php echo __('Select the areas you want to find members in. To view a detailed map, roll-over the ares names..') ?><br /><br />

<div id="areas_map"></div>

<form action="<?php echo url_for('search/selectAreas')?>" id="areas" method="post">
    <?php echo input_hidden_tag('country', $sf_request->getParameter('country'), array('id' => 'country')) ?>
    <?php echo input_hidden_tag('polish_cities', $sf_request->getParameter('polish_cities')) ?>
    <?php echo link_to(__('Cancel and return to search'), $sf_user->getRefererUrl(), array('class' => 'sec_link_small')) ?><br />
    <input type="submit" value="Save" class="save" /><br />
    <fieldset>
        <?php foreach ($areas as $area): ?>
            <?php echo checkbox_tag('areas[]', $area->getId(), in_array($area->getId(), $sf_data->getRaw('selected_areas'))) ?>
            <label for="areas_<?php echo $area->getId() ?>"><?php echo link_to_function($area->getTitle(), 
                        'void()', 
                        array('class' => 'slf', 
                              'onmouseover' => 'show_area("'. $area->getTitle().'")',
                              'onmouseout' => "map.removeOverlay(g_marker)"
                        )) ?></label><br />
        <?php endforeach; ?>
    </fieldset>
    
    <br class="clear" />
    <input type="submit" value="Save" class="save" /><br />
    <?php echo link_to(__('Cancel and return to search'), $sf_user->getRefererUrl(), array('class' => 'sec_link_small')) ?>
</form>


<script>
var country = document.getElementById('country').value;
init_area_map();
</script>