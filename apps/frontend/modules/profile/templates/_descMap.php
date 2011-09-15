<?php use_helper('prDate', 'dtForm'); ?>

<div id="desc_map_container">
    <div id="profile_desc">
        <?php echo link_to_function(__('Description'), '', 'class=switch') ?>
        <?php $area_info = addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getCityId() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))); ?>
        <?php echo link_to_function(__('Map'), 
                    'show_profile_map("'. $member->getGAddress() . '", "'. $area_info .'")', 
                    'class=inactive switch');
         ?>
        <br class="clear" />
        <dl>
            <dt><?php echo __('Orientation') ?></dt>
                <dd><?php echo __($member->getOrientationString()) ?></dd>
            
            <dt><?php echo __('Purpose') ?></dt>
                <?php $purposes = $member->getPurpose(); ?>
                <?php if( count($purposes) ): ?>
                    <dd><?php echo format_purpose($purposes[0], $member->getOrientationKey()); ?></dd>
                    
                    <?php for($i = 1; $i < count($purposes); $i++): ?>
                        <dt>&nbsp;</dt><dd><?php echo format_purpose($purposes[$i], $member->getOrientationKey()); ?></dd>
                    <?php endfor; ?>

                <?php else: ?>
                  <dd> - </dd>
                <?php endif; ?>

            
            <dt><?php echo __('Country') ?></dt>
                <dd><?php echo ($member->getCountry()) ? pr_format_country($member->getCountry()) : "-" ?></dd>
            
            <dt><?php echo __('Area') ?></dt>
                <?php if( $member->getAdm1Id() ): ?>
                  <dd><?php echo $member->getAdm1() . '&nbsp;' . link_to(__('(other profiles from this area)'), 'search/areaFilter?id=' . $member->getAdm1Id(), 'class=sec_link') ?></dd>
                <?php else: ?>
                  <dd> - </dd>
                <?php endif; ?>
            
            <dt><?php echo __('District') ?></dt>
                <dd><?php echo ($member->getAdm2Id()) ? $member->getAdm2() : '-'; ?></dd>
            
            <dt><?php echo __('City') ?></dt>
                <dd><?php echo ($member->getCity()) ? $member->getCity() : '-'; ?></dd>
                
            <dt><?php echo __('Zodiac') ?></dt>
                <dd><?php echo ($member->getBirthday() && !$member->getDontDisplayZodiac()) ? __($member->getZodiac()->getSign()) : '-'; ?></dd>

            <?php foreach ($questions as $question): ?>
              <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                <dt><?php echo __($question->getDescTitle(ESC_RAW)) ?></dt>
                  <?php $member_answer = isset($member_answers[$question->getId()]) ? $member_answers[$question->getId()] : null; ?>
                  <?php if( $member_answer ): ?>
                    <dd>
                        <?php $other = $member_answer->getOther(); ?>
                        <?php if( is_null($other) && $member_answer->getDescAnswerId() ): ?>
                            <?php echo __($answers[$member_answer->getDescAnswerId()]->getTitle(ESC_RAW)) ?>
                        <?php elseif( !is_null($other) ): ?>
                            <?php echo $other; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </dd>
                  <?php else: ?>
                    <dd> - </dd>
                  <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            
            
            <dt><?php echo __('Language'); ?></dt>
                <?php $no_language = true ?>
                
                <?php foreach ($questions as $question): ?>
                    <?php $member_answer = isset($member_answers[$question->getId()]) ? $member_answers[$question->getId()] : null; ?>
                    <?php if( $question->getType() == 'native_lang' && $member_answer ): ?>
                        <?php $no_language = false; ?>
                        <dd><?php echo ( is_null($member_answer->getOther()) ) ? format_language($member_answer->getCustom()) : $member_answer->getOther() ?> (<?php echo __('native'); ?>)</dd>
                    <?php elseif( $question->getType() == 'other_langs' && $member_answer ): ?>
                        <?php if( is_null($member_answer->getOther()) ): ?>
                            <?php foreach ($member_answer->getOtherLangs() as $lang_answer): ?>
                                <?php if( $lang_answer['lang'] ): ?>
                                        <dt>&nbsp;</dt><dd><?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <dt>&nbsp;</dt><dd><?php echo $member_answer->getOther(); ?></dd>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            
                <?php if( $no_language ): ?>
                  <dd> - </dd>
                <?php endif; ?>
        </dl>
    </div>
    <div id="profile_map" style="display: none;">
        <?php echo link_to_function(__('Description'), 'show_profile_desc()', 'class=inactive switch') ?>
        <?php echo link_to_function(__('Map'), '', 'class=switch') ?>
        <br class="clear" />
        <div id="gmap"></div>
    </div>
    <br class="clear" />
</div>