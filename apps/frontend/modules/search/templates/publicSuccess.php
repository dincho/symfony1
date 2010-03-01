<?php use_helper('Date', 'dtForm') ?>

<p><?php echo __('To see more profiles, set your preferences and to use our search engine, please join for free now.') ?></p>

<form action="<?php echo url_for('search/' . sfContext::getInstance()->getActionName()) ?>" id="search_box" class="public_matches">
    <table border="0" cellpadding="0" cellspacing="0" class="search_filter">
      <tbody>
        <tr class="search_filter_top_row">
            <td><?php echo __('You are') ?></td>
            <td colspan="2">
              <?php echo select_tag('filters[looking_for]', looking_for_options(isset($filters['looking_for']) ? $filters['looking_for'] : null)) ?>
            </td>
            <td>
                <?php echo __('Age'); ?> 
                <?php echo input_tag('filters[age_from]', isset($filters['age_from']) ? $filters['age_from'] : 18, array('class' => 'age')) ?>
                &nbsp;<?php echo __('to') ?>&nbsp;
                <?php echo input_tag('filters[age_to]',  isset($filters['age_to']) ? $filters['age_to'] : 35, array('class' => 'age')) ?>
            </td>
            <td>
                <?php echo checkbox_tag('filters[only_with_photo]', 1, isset($filters['only_with_photo']), array('class' => 'margin_right_zero')) ?>&nbsp;<?php echo __('Show only profiles with photo') ?>
            </td>
        </tr>
        <tr class="separator">
            <td colspan="5"></td>
        </tr>
        <tr class="search_filter_middle_row">
            <td class="search_filter_row_label"><?php echo __('Location') ?></td>
            <td><?php echo radiobutton_tag('filters[location]', 0, ($filters['location'] == 0), array('class' => 'margin_right_zero')) . __('Everywhere') ?></td>
            <td><?php echo radiobutton_tag('filters[location]', 1, ($filters['location'] == 1), array('class' => 'margin_right_zero')) . __('In selected countries only') ?></td>
            <td><?php echo radiobutton_tag('filters[location]', 2, ($filters['location'] == 2), array('class' => 'margin_right_zero')) . __('In my area only') ?></td>
            <td><?php echo checkbox_tag('filters[include_poland]', 1, isset($filters['include_poland']), array('class' => 'margin_right_zero')) . __('Include matches in Poland') ?></td>
        </tr>
        <tr class="search_filter_bottom_row">
            <td></td>
            <td></td>
    
            <td><?php echo link_to(__('Select Countries'), 'search/selectCountries', array('class' => 'sec_link')) ?></td>
            <td></td>
            <td><?php echo link_to(__('Select Cities'), 'search/selectAreas?country=PL&polish_cities=1', array('class' => 'sec_link')) ?></td>
        </tr>
        <tr class="actions">
            <td colspan="5"><?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results')")) ?></td>
        </tr>
      </tbody>
  </table> 

</form>

<div id="match_results">
    <?php include_partial('public_pager'); ?>
    <div class="member">
        <?php $i=1;foreach($members as $member): ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
                <div class="header">
                    <div class="age"><?php echo $member->getAge() ?></div>
                    <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 39) ?></div>
                </div>
                <?php echo image_tag($member->getMainPhoto()->getImg('80x100')) ?>
                <div class="profile_info">
                    <p class="profile_location"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
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
    <?php include_partial('public_pager'); ?>
</div>

<br class="clear" />