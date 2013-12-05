<?php use_helper('Date', 'prProfilePhoto', 'prLink', 'dtForm', 'Javascript') ?>

<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/profileID')?>" method="post">
    <label for="profile_id"><?php echo __('Enter profile ID') ?></label>
    <?php echo input_tag('profile_id', null, array('id' => 'profile_id', 'class' => 'input_text_width')); ?><br />
    <?php echo submit_tag(__('Search'), array('class' => 'button')) ?>
</form>

<br /><br />

<?php if( isset($member) ): ?>
<div class="member">
    <div class="member_box">  
        <div class="header">
            <div class="age"><?php echo $member->getAge() ?></div>
            <div class="headline"><?php echo Tools::truncate($member->getEssayHeadline(), 35) ?></div>
        </div>
        <?php echo profile_photo($member, 'float-left') ?>
      <div class="profile_info">
            <?php if( $member->getMillionaire() ): ?>
                <div class="millionaire_mark"><?php echo __('M'); ?></div>
            <?php endif; ?>

          <p class="profile_location_mini"><?php echo Tools::truncate(pr_format_country($member->getCountry()) . ', ' . $member->getCity(), 45) ?></p>
          <p><?php echo link_to_ref(__('View Profile'), '@profile?username=' . $member->getUsername()) . ' | ' ?> 
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
</div>
<?php elseif($sf_request->getParameter('profile_id')): ?>
    <div class="msg_error text-center"><?php echo __('We could not find a member with the ID you specified, please make sure you have the right ID number or use another type of search') ?></div>
<?php endif; ?>




