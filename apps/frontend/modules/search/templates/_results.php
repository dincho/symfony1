<?php use_helper('Date') ?>

<div id="match_results">
    <?php include_partial('pager', array('pager' => $pager, 'route' => $route)); ?>
    <div class="member">
        <?php $i=1;foreach($pager->getResults() as $match): ?>
            <?php $member = $match->getMemberRelatedByMember2Id(); ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?><span><?php echo $member->getAge() ?></span></h2>
                <?php echo image_tag($member->getMainPhoto()->getImg('80x100')) ?>
                
                <div class="profile_info">
                    <p class="profile_location"><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></p>
                    <p></p>
                    <p><?php echo link_to('View Profile', '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?></p>
                    <p><?php echo link_to(__('Add to hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?></p>
                    <p></p>
                    <p><?php echo __('Last seen: %WHEN%', array('%WHEN%' => distance_of_time_in_words($member->getLastLogin(null)))) ?></p>
                    <?php if( !is_null($match->getReversePct())): ?>
                        <p><?php echo __('%she_he% matches you: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => $match->getReversePct(), '%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?></p>
                    <?php endif; ?>
                    <p><?php echo __('You match %her_him%: %MATCH%%', array('%MATCH%' => $match->getPct(), '%her_him%' => ( $member->getSex() == 'M' ) ? 'him' : 'her')) ?></p>
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

