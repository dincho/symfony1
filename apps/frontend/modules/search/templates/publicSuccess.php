<?php use_helper('Date', 'dtForm') ?>

<?php echo __('To see more profiles, set your preferences and to use our search engine, please <a href="%URL_FOR_JOIN_NOW%" class="sec_link">join for free now</a>.', array('%URL_FOR_JOIN_NOW%' => url_for('registration/joinNow'))) ?>
<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
    <p class="search_p">
        <label for="looking_for" style="margin-right: 15px"><?php echo __('You are') ?></label>
        <?php echo select_tag('filters[looking_for]', looking_for_options(isset($filters['looking_for']) ? $filters['looking_for'] : null)) ?>
        
        <label><?php echo __('Age') ?></label>
        <?php echo input_tag('filters[age_from]', isset($filters['age_from']) ? $filters['age_from'] : 18, array('class' => 'age')) ?>
        <label><?php echo __('to') ?></label>
        <?php echo input_tag('filters[age_to]',  isset($filters['age_to']) ? $filters['age_to'] : 35, array('class' => 'age', 'style' => 'margin-right: 60px')) ?>
        
        <?php echo checkbox_tag('filters[only_with_video]', 1, isset($filters['only_with_video']), array('style' => 'margin-right: 0')) ?>
        <label for="filters_only_with_video"><?php echo __('Show only profiles with video') ?></label>
    </p>
    <p class="search_p" style="height: 35px; border: none; text-align: left;">
        <label style="margin-right: 8px"><?php echo __('Location') ?></label>
        <?php echo radiobutton_tag('filters[location]', 0, ($filters['location'] == 0), array('style' => 'margin-right: 0') ) ?>
        <label for="filter_location_0" style="margin-right: 25px"><?php echo __('Everywhere') ?></label>
        
        <?php echo radiobutton_tag('filters[location]', 1, ($filters['location'] == 1), array('style' => 'margin-right: 0') ) ?>
        <label for="filter_location_1"  style="margin-right: 25px"><?php echo __('In selected countries only') ?></label>
        
        
        <?php echo radiobutton_tag('filters[location]', 2, ($filters['location'] == 2), array('style' => 'margin-right: 0') ) ?>
        <label for="filter_location_2"  style="margin-right: 92px"><?php echo __('In my area only') ?></label>
        
        &nbsp;
        <?php echo checkbox_tag('filters[include_poland]', 1, isset($filters['include_poland']), array('style' => 'margin-right: 0')  ) ?>
        <label for="filters_include_poland"><?php echo __('Include matches in Poland') ?></label><br />
        
        <?php echo link_to(__('Select Countries'), 'search/selectCountries', array('style' => 'margin-left: 182px;')) ?>
        <?php echo link_to(__('Select Cities'), 'search/selectAreas?country=PL&polish_cities=1', array('style' => 'margin-left: 282px;')) ?>
    </p>
    
    <?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results')")) ?>
</form>

<div id="match_results">
    <?php if(count($members) == 12) include_partial('public_pager'); ?>
    <div class="member">
        <?php $i=1;foreach($members as $member): ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?><span><?php echo $member->getAge() ?></span></h2>
                <?php echo image_tag($member->getMainPhoto()->getImg('80x100')) ?>
                <div class="profile_info">
                    <p class="profile_location"><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></p>
                    <p></p>
                    <p></p>
                    <p><?php echo link_to('View Profile', 'registration/joinNow', array('class' => 'sec_link')) ?></p>
                    <p></p>
                    <p></p>
                    <p><?php echo __('Last seen: %WHEN%', array('%WHEN%' => distance_of_time_in_words($member->getLastLogin(null)))) ?></p>
                </div>
            </div>  
            <?php if( $i < 12 && $i%3 == 0): ?>
            </div>
            <div class="member">
            <?php endif; ?>  
        <?php $i++;endforeach; ?>
    </div>
    <?php if(count($members) == 12) include_partial('public_pager'); ?>
</div>
