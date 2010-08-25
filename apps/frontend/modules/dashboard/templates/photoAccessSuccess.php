<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink', 'Javascript') ?>

<div id="winks">
    <div class="you_recived">
        <?php echo __('Members who granted you an access to their private photos')?><br /><br />
        <?php foreach ($other_grants as $perm): ?>
            <?php $member = $perm->getMemberRelatedByMemberId(); ?>
            <div class="member_profile">
                <h2><?php echo Tools::truncate($member->getEssayHeadline(), 40) ?></h2> <span class="number"><?php echo $member->getAge() ?></span>
                <?php echo link_to_ref(profile_photo($member, 'float-left'), '@profile?bc=hotlist&username=' . $member->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice">
                        <?php echo __('%she_he% granted you access %date%', 
                                   array('%date%' => distance_of_time_in_words($perm->getCreatedAt(null)),
                                         '%she_he%' => ( $member->getSex() == 'M' ) ? __('He') : __('She'),
                                         '%her_his%' => ( $member->getSex() == 'M' ) ? __('his') : __('her')
                               )); ?>
                    </span>
                    <?php echo link_to_ref(__('View Profile'), '@profile?bc=hotlist&username=' . $member->getUsername(), array('class' => 'sec_link')) ?>
                </div>
            </div>        
        <?php endforeach; ?>
    </div>
    
    <div class="you_sent">
        <?php echo __('Members whom you granted an access to your private photos')?><br />
        <span><?php echo __('Click on the "x" in the lower corner of a profile to remove it from the list.')?></span><br /><br />
        <?php foreach ($my_grants as $perm): ?>
            <?php $profile = $perm->getMemberRelatedByProfileId(); ?>
            <div class="member_profile" id="member_profile_<?php echo $profile->getId();?>">
                <h2><?php echo Tools::truncate($profile->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $profile->getAge() ?></span>
                <?php echo link_to_ref(profile_photo($profile, 'float-left'), '@profile?bc=hotlist&username=' . $profile->getUsername()) ?>
                <div class="input">
                    <span class="public_reg_notice"><?php echo __('Access granted %date%', array('%date%' => distance_of_time_in_words($perm->getCreatedAt(null)))) ?></span>
                    <?php echo link_to_ref(__('View Profile'), '@profile?bc=hotlist&username=' . $profile->getUsername(), array('class' => 'sec_link')) ?><br />
                    <?php echo link_to_remote(__('Revoke Access'), array(
                                                    'url' => '@toggle_private_photos_perm?username=' . $profile->getUsername(),
                                                    'update' => array('success' => 'msg_container'),
                                                    'script' => true, 
                                                    'after' => '$("member_profile_'.$profile->getId().'").remove();'
                                            ), array('class' => 'sec_link', )); ?>
                </div>
                <?php echo link_to_remote(image_tag('butt_x.gif', 'class=x'), array(
                                                'url' => '@toggle_private_photos_perm?username=' . $profile->getUsername(),
                                                'update' => array('success' => 'msg_container'),
                                                'script' => true, 
                                                'after' => '$("member_profile_'.$profile->getId().'").remove();'
                                        ), array('class' => 'sec_link', )); ?>
            </div>        
        <?php endforeach; ?>
    </div>
</div>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>

