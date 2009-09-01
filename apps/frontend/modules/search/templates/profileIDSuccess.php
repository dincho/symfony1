<?php use_helper('prDate', 'prProfilePhoto') ?>

<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/profileID')?>" method="post">
    <label for="profile_id"><?php echo __('Enter profile ID') ?></label>
    <input type="text" name="profile_id" class="input_text_width" id="profile_id" /><br />
    <?php echo submit_tag(__('Search'), array('class' => 'button')) ?>
</form>

<br /><br />

<?php if( isset($member) ): ?>
<div class="member">
        <div class="member_box">
        	<?php if( $member->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
            <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2><span><?php echo $member->getId() ?></span>
            <?php echo profile_photo($member, 'float-left') ?>            
            <div class="profile_info">
                <p class="profile_location"><?php echo format_country($member->getCountry()) . ', ' . $member->getCity() ?></p>
                <p></p>
                <?php if( $member->isActive() ): ?>
                    <p><?php echo link_to('View Profile', '@profile?username=' . $member->getUsername(), array('class' => 'sec_link')) ?></p>
                    <p><?php echo link_to(__('Add to hotlist'), 'hotlist/add?profile_id=' . $member->getId(), array('class' => 'sec_link')) ?></p>
                <?php else: ?>
                    <p></p><p></p>
                <?php endif; ?>
                <p></p>
                <?php $when =  ($member->isLoggedIn()) ? 'Online' : pr_distance_of_time_in_words($member->getLastLogin(null)); ?>
                <p><?php echo __('Last seen: %WHEN%', array('%WHEN%' => $when)) ?></p>
            </div>
            <?php else: ?>
            <h2>&nbsp;</h2>
            <?php echo profile_photo($member, 'float-left') ?>
                <div class="profile_info">                	
                	<p class="profile_location"><span class="profile_not_available_dash_matsh"><?php echo  __('Sorry, this profile is no longer available') ?></span></p>
                </div>        
           <?php endif; ?>
        </div>
</div>
<?php elseif($sf_request->getParameter('profile_id')): ?>
    <div class="msg_error text-center"><?php echo __('We could not find a member with the ID you specified, please make sure you have the right ID number or use another type of search') ?></div>
<?php endif; ?>




