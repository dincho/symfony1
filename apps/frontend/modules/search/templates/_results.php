<?php use_helper('Date', 'prProfilePhoto', 'prLink', 'dtForm') ?>

<?php if( $pager->getNbResults() > 0): ?>
<div id="match_results">
    <?php include_partial('pager', array('pager' => $pager, 'route' => $route)); ?>
    <div class="member">
        <?php $i=1;foreach($pager->getResults() as $match): ?>
            <?php $member = $match->getMemberRelatedByMember2Id(); ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">  
                <div class="header">
                    <div class="age"><?php echo $member->getAge() ?></div>
                    <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 38) ?></div>
                </div>
              <?php echo profile_photo($member, 'float-left') ?>
              <div class="profile_info">
                    <?php if( $member->getMillionaire() ): ?>
                        <div class="millionaire_mark"><?php echo __('M'); ?></div>
                    <?php endif; ?>

                  <p class="profile_location"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
                  
                  
                  <p><?php echo link_to_ref(__('View Profile'), '@profile?pager=1&bc=search&username=' . $member->getUsername(), array('class' => 'sec_link')) ?></p>
                  <p>
                      <?php if( $sf_user->getProfile()->hasInHotlist($member->getId()) ): ?>
                        <?php echo link_to_ref(__('Remove from hotlist'), 'hotlist/delete?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>
                      <?php else: ?>
                        <?php echo link_to_ref(__('Add to hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?>
                      <?php endif; ?>
                  </p>
                  <p><?php include_partial('search/last_action', array('match' => $match)); ?></p>
                  <?php $when = (is_null($member->getLastLogin())) ? __('never') : distance_of_time_in_words($member->getLastLogin(null)); ?>
                  <p><?php echo __('last log in: %WHEN%', array('%WHEN%' => $when)) ?></p>
                  <?php if( $sf_user->getProfile()->hasSearchCriteria()): ?>
                      <p><?php echo __('%she_he% matches you: %MATCH%%', array('%MATCH%' => $match->getPct(), '%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?></p>
                  <?php else: ?>
                      <p><?php echo __('%she_he% matches you: set criteria', array('%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?></p>
                  <?php endif; ?>
                  <p><?php echo __('You match %her_him%: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => (int) $match->getReversePct(), '%her_him%' => ( $member->getSex() == 'M' ) ? __('him') : __('her'))) ?></p>
              </div>
            </div>  
            <?php if( $i < $pager->getMaxPerPage() && $i%3 == 0): ?>
            </div>
            <div class="member">
            <?php endif; ?>  
        <?php $i++;endforeach; ?>
    </div>
    <?php include_partial('pager', array('pager' => $pager, 'route' => $route)); ?>
</div>
<?php endif; ?>