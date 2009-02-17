    <p class="search_p">
    
        <?php echo checkbox_tag('filters[only_with_video]', 1, isset($filters['only_with_video'])) ?>
        <label for="filters_only_with_video"><?php echo __('Show only profiles with video') ?></label>
    </p>
    <p class="search_p" style="height: 35px; border: none;">
    
        <?php echo __('Location') ?>
        &nbsp;&nbsp;
        <?php echo radiobutton_tag('filters[location]', 0, ($filters['location'] == 0) ) ?>
        <label for="filters_location"><?php echo __('Everywhere') ?></label>
        &nbsp;&nbsp;&nbsp;
        <?php echo radiobutton_tag('filters[location]', 1, ($filters['location'] == 1) ) ?>
        <label for="filters_location_1"><?php echo __('In selected countries only') ?></label>
        <span><?php echo link_to(__('Select Countries'), 'search/selectCountries') ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo radiobutton_tag('filters[location]', 2, ($filters['location'] == 2) ) ?>
        <label for="filters_location_2"><?php echo __('In my area only') ?></label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo checkbox_tag('filters[include_poland]', 1, isset($filters['include_poland'])  ) ?>
        <label for="filters_include_poland"><?php echo __('Include matches in Poland') ?></label>
        <span><?php echo link_to(__('Select Cities'), 'search/selectAreas?country=PL&polish_cities=1') ?></span>
    </p>
        <?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results')")) ?>
</form>