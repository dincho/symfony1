<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink', 'Javascript') ?>

<?php $profile = $hotlist->getMemberRelatedByProfileId(); ?>

<div class="member_profile" id="member_<?php echo $profile->getId(); ?>">
    <h2><?php echo Tools::truncate($profile->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $profile->getAge() ?></span>
    <?php echo link_to_ref(profile_photo($profile), '@profile?bc=hotlist&username=' . $profile->getUsername(), array('class' => 'photo_link', )) ?>
    <div class="input">
        <span class="public_reg_notice"><?php echo __('Added to your hotlist %date%', array('%date%' => distance_of_time_in_words($hotlist->getCreatedAt(null)))) ?></span>
        <?php echo link_to_ref(__('View Profile'), '@profile?bc=hotlist&username=' . $profile->getUsername(), array('class' => 'sec_link')) ?><br />
        <?php echo link_to_remote(__('Remove from Hotlist'),
                                  array('url'     => 'hotlist/toggle?profile_id=' . $profile->getId() . '&show_element=member_' . $profile->getId(),
                                        'update'  => 'msg_container',
                                        'success' => '$("member_'. $profile->getId() .'").hide();',
                                        'script'  => true
                                      )
                    ); ?>
                    <?php include_partial('content/onlineProfile', array('member' => $profile)) ?>
    </div>
    <?php echo link_to_remote(image_tag('butt_x.gif', 'class=x'),
                              array('url'     => 'hotlist/toggle?profile_id=' . $profile->getId() . '&show_element=member_' . $profile->getId(),
                                    'update'  => 'msg_container',
                                    'success' => '$("member_'. $profile->getId() .'").hide();',
                                    'script'  => true
                                  )
                ); ?>

</div>