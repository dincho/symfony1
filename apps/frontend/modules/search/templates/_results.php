<?php use_helper('Date') ?>

<div id="match_results">
    <?php include_partial('pager', array('pager' => $pager, 'route' => $route)); ?>
    <div class="member">
        <?php $i=1;foreach($pager->getResults() as $match): ?>
            <?php $member = $match->getMemberRelatedByMember2Id(); ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span><?php echo $member->getId() ?></span>
                <?php echo image_tag($member->getMainPhoto()->getImg('100x100'), array('style' => 'vertical-align:middle;')) ?>
                
                <div class="profile_info_matches">
                    <strong><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></strong><br />
                    <?php echo link_to('View Profile', '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?><br />
                    <?php echo link_to(__('Add to hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?><br />
                    <b><?php echo __('Last seen: %WHEN%', array('%WHEN%' => distance_of_time_in_words($member->getLastLogin(null)))) ?></b><br />
                    <b><?php echo __('%she_he% matches you: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => $match->getReversePct(), '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?></b><br />
                    <b><?php echo __('You match %her_him%: %MATCH%%', array('%MATCH%' => $match->getPct(), '%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her')) ?></b><br />
                </div>
            </div>  
            <?php if( $i < 12 && $i%3 == 0): ?>
            </div>
            <div class="member">
            <?php endif; ?>  
        <?php $i++;endforeach; ?>
    </div>
    <?php include_partial('pager', array('pager' => $pager, 'route' => $route)); ?>
</div>
