<?php use_helper('prDate', 'dtForm'); ?>

<div id="desc_map_container">
    <div id="profile_desc">
        <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=switch') ?>
        <?php $area_info = addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getCityId() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))); ?>
        <?php echo link_to_function(__('Map'), 
                    'show_profile_map("'. $member->getGAddress() . '", "'. $area_info .'")', 
                    'class=switch inactive');
         ?>
        <br class="clear" />
        <dl>
            <dt><?php echo __('Orientation') ?></dt>
                <dd><?php echo __($member->getOrientationString()) ?></dd>
            
            <?php if( count($member->getPurpose()) ): ?>
            <dt><?php echo __('Purpose') ?></dt>
                <dd>
                    <?php foreach($member->getPurpose() as $purpose): ?>
                        <?php echo format_purpose($purpose, $member->getOrientationKey()); ?><br />
                    <?php endforeach; ?>
                </dd>
            <?php endif; ?>
            
            <dt><?php echo __('Country') ?></dt>
                <dd><?php echo pr_format_country($member->getCountry()) ?></dd>
            
            <?php if( $member->getAdm1Id() ): ?>
                <dt><?php echo __('Area') ?></dt>
                    <dd><?php echo $member->getAdm1() . '&nbsp;' . link_to(__('(other profiles from this area)'), 'search/areaFilter?id=' . $member->getAdm1Id(), 'class=sec_link') ?></dd>
            <?php endif; ?>
            
            <?php if( $member->getAdm2Id() ): ?>
                <dt><?php echo __('District') ?></dt>
                    <dd><?php echo $member->getAdm2(); ?></dd>
            <?php endif; ?>
            
            <dt><?php echo __('City') ?></dt>
                <dd><?php echo $member->getCity() ?></dd>
                
            <?php if( $member->getBirthday() && !$member->getDontDisplayZodiac() ): ?>
                <dt><?php echo __('Zodiac') ?></dt>
                    <dd><?php echo __($member->getZodiac()->getSign()) ?></dd>
            <?php endif; ?>

            <?php foreach ($questions as $question): ?>
                <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                
                    <?php if( isset($member_answers[$question->getId()]) ): ?>
                        <dt><?php echo __($question->getDescTitle(ESC_RAW)) ?></dt>
                        <dd>
                            <?php $other = $member_answers[$question->getId()]->getOther(); ?>
                            <?php if( is_null($other) && $member_answers[$question->getId()]->getDescAnswerId() ): ?>
                                <?php echo __($answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle(ESC_RAW)) ?>
                            <?php elseif( !is_null($other) ): ?>
                                <?php echo $other; ?>
                            <?php else: ?>
                                <?php echo __('not provided'); ?>
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