<?php use_helper('Date', 'prProfilePhoto', 'prLink', 'dtForm', 'Javascript') ?>

<?php if( $pager->getNbResults() > 0): ?>
<div id="match_results">
    <?php include_partial('content/pager', array('pager' => $pager, 'route' => $route)); ?>
    <div class="member">
        <?php $i=1;foreach($pager->members as $member): ?>
            <div class="member_box <?php echo ($i%3 == 0) ? 'last_box' :''; ?>">  
                <div class="header">
                    <div class="age"><?php echo $member->getAge() ?></div>
                    <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 35) ?></div>
                </div>
                <?php $ppo = ($pager->getPage()-1)*$pager->getMaxPerPage() + $i; ?>
              <?php echo link_to_ref( profile_photo($member, 'float-left'), '@profile?username=' . $member->getUsername() . '&page=' . $ppo) ?>
              <div class="profile_info">
                    <?php if( $member->getMillionaire() ): ?>
                        <div class="millionaire_mark"><?php echo __('M'); ?></div>
                    <?php endif; ?>

                  <p class="profile_location_mini"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
                  
                  
                  <p>
                    <?php echo link_to_ref(__('View Profile'), '@profile?username=' . $member->getUsername() . '&page=' . $ppo, array('class' => 'sec_link')) . ' | ' ?> 
                    <?php $hotlist_link_title = ( $sf_user->getProfile()->hasInHotlist($member->getId()) ) ? __('Remove from Hotlist') : __('Add to Hotlist'); ?>
                    <?php echo link_to_remote($hotlist_link_title,
                                              array('url'     => 'hotlist/toggle?update_selector=hotlist_link_'.$member->getId().'&profile_id=' . $member->getId(),
                                                    'update'  => 'msg_container',
                                                    'script'  => true
                                                  ),
                                              array('class' => 'sec_link',
                                                    'id'    => 'hotlist_link_' . $member->getId(), 
                                                    )
                                ); ?>
                  </p>
                  <?php $when = (is_null($member->getLastLogin())) ? __('never') : distance_of_time_in_words($member->getLastLogin(null)); ?>
                  <p><?php echo __('last log in: %WHEN%', array('%WHEN%' => $when)) ?></p>
                  <?php if( $sf_user->getProfile()->hasSearchCriteria()): ?>
                      <p><?php echo __('%she_he% matches you: %MATCH%%', array('%MATCH%' => $member->getMemberMatch()->getPct(), '%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?></p>
                  <?php else: ?>
                      <p><?php echo __('%she_he% matches you: set criteria', array('%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'))) ?></p>
                  <?php endif; ?>
                  <p><?php echo __('You match %her_him%: %REVERSE_MATCH%%', array('%REVERSE_MATCH%' => $member->getMemberMatch()->getReversePct(), '%her_him%' => ( $member->getSex() == 'M' ) ? __('him') : __('her'))) ?></p>
              </div>
            </div>  
            <?php if( $i < $pager->getMaxPerPage() && $i%3 == 0): ?>
            </div>
            <div class="member">
            <?php endif; ?>  
        <?php $i++;endforeach; ?>
    </div>
    <?php include_partial('content/pager', array('pager' => $pager, 'route' => $route)); ?>
</div>
<?php endif; ?>