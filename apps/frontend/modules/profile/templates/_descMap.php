<div id="desc_map_container">
    <div id="profile_desc">
        <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch') ?>
        <?php $area_info = ($member->getAdm1Id() && $member->getAdm1()->getInfo()) ? addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getAdm1Id() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))) : null; ?>
        <?php echo link_to_function(__('Map'), 
                    'show_profile_map("'. $member->getGAddress() . '", "'. $area_info .'")', 
                    'class=switch inactive');
         ?>
        <br class="clear" />
        <dl>
            <dt><?php echo __('Orientation') ?></dt><dd><?php echo __($member->getOrientationString()) ?></dd>
            <dt><?php echo __('Country') ?></dt><dd><?php echo format_country($member->getCountry()) ?></dd>
            <dt><?php echo __('Area') ?></dt><dd><?php echo ($member->getAdm1Id()) ? $member->getAdm1() : __('None') ?>&nbsp;<?php if($member->getAdm1Id()) echo link_to(__('(other profiles from this area)'), 'search/areaFilter?id=' . $member->getAdm1Id(), 'class=sec_link') ?></dd>
            <dt><?php echo __('District') ?></dt><dd><?php echo ($member->getAdm2Id()) ? $member->getAdm2() : __('None') ?></dd>
            <dt><?php echo __('City') ?></dt><dd><?php echo $member->getCity() ?></dd>
            <?php if( !$member->getDontDisplayZodiac() ): ?>
                <dt><?php echo __('Zodiac') ?></dt><dd><?php echo __($member->getZodiac()->getSign()) ?></dd>
            <?php endif; ?>

            <?php foreach ($questions as $question): ?>
                <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                
                    <?php if( isset($member_answers[$question->getId()]) && 
                              ($member_answers[$question->getId()]->getDescAnswerId() || $member_answers[$question->getId()]->getOther()) ): ?>
                        <dt><?php echo __($question->getDescTitle(ESC_RAW)) ?></dt>
                        <dd>
                            <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                <?php echo __($answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle(ESC_RAW)) ?>
                            <?php else: ?>
                                <?php echo $member_answers[$question->getId()]->getOther(); ?>
                            <?php endif; ?>
                        </dd>
                    <?php endif; ?>
                <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
                
                <dt><?php echo __('Language'); ?></dt><dd><?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (<?php echo __('native'); ?>)</dd>
                <?php elseif( $question->getType() == 'other_langs' ): ?>
                    <?php if( isset($member_answers[$question->getId()]) ): ?>
                        <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                            <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                            <?php foreach ($lang_answers as $lang_answer): ?>
                                <?php if( $lang_answer['lang'] ): ?>
                                    <dt>&nbsp;</dt><dd><?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <dt>&nbsp;</dt><dd><?php echo $member_answers[$question->getId()]->getOther(); ?></dd>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            
        </dl>
    </div>
    <div id="profile_map" style="display: none;">
        <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch inactive') ?>
        <?php echo link_to_function(__('Map'), 'show_profile_map()', 'class=switch') ?>
        <br class="clear" />
        <div id="gmap"></div>
    </div>
    <br class="clear" />
</div>