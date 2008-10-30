<?php use_helper('Date', 'dtForm') ?>

<?php echo __('To see more profiles, set your preferences and to use our search engine, please <a href="%URL_FOR_JOIN_NOW%" class="sec_link">join for free now</a>.', array('%URL_FOR_JOIN_NOW%' => url_for('registration/joinNow'))) ?>
<form action="" id="search_box" class="public_matches">
    <p class="search_p">
        <label for="you_are">You are</label>
        <?php echo select_tag('looking_for', looking_for_options()) ?>
        Age
        <input type="text" class="age" /> to <input type="text" class="age" />
        <input value="" type="checkbox" class="location" id="only_video" /> <label for="only_video">Show only profiles with video</label>
    </p>
    <p class="search_p">
        Location
        <input type="radio" name="gr1" class="location" id="everywhere" /> <label for="everywhere">Everywhere</label>
        <input type="radio" name="gr1" class="location" id="selected_countries" /> <label for="selected_countries">In selected countries only</label>
        <span><a href="#">Select Countries</a></span>
        <input type="radio" name="gr1" class="location" id="state_province_only" /> <label for="state_province_only">In my state/province only</label>
        <input type="checkbox" class="location" id="matches_poland" /> <label for="matches_poland">Include matches in Poland </label>
        <span><a href="#">Select Cities</a></span>
    </p>
    <div id="input_matches_button">
        <input type="submit" value="" class="public_matches_search" />
    </div>
</form>

<div class="pager">
    <span>Page</span>
    <?php foreach (range(1, 5) as $page): ?>
        <?php echo link_to_unless($page == 1, $page, 'registration/joinNow') ?>
    <?php endforeach; ?>
    <?php echo link_to(image_tag('next.gif'), 'registration/joinNow') ?>
</div>
    
<div class="member">
    <?php $i=1;foreach($members as $member): ?>
        <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
            <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span><?php echo $member->getId() ?></span>
            <?php echo image_tag($member->getMainPhoto()->getImg('100x100'), array('style' => 'vertical-align:middle;')) ?>
            
            <div class="profile_info_matches">
                <strong><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></strong><br /><br />
                <?php echo link_to('View Profile', 'registration/joinNow', array('class' => 'sec_link')) ?><br /><br />
                <b><?php echo __('Last seen: %WHEN%', array('%WHEN%' => distance_of_time_in_words($member->getLastLogin(null)))) ?></b><br />
            </div>
        </div>  
        <?php if( $i < 12 && $i%3 == 0): ?>
        </div>
        <div class="member">
        <?php endif; ?>  
    <?php $i++;endforeach; ?>
</div>

<div class="pager">
    <span>Page</span>
    <?php foreach (range(1, 5) as $page): ?>
        <?php echo link_to_unless($page == 1, $page, 'registration/joinNow') ?>
    <?php endforeach; ?>
    <?php echo link_to(image_tag('next.gif'), 'registration/joinNow') ?>
</div>