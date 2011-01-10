<?php use_helper('prDate', 'prProfilePhoto', 'Date', 'prLink', 'Javascript') ?>
<?php echo javascript_include_tag('fixPrivacyProfileViewersIE');?>

<?php echo __('These users are able to see you. Click on the "x" in the lower corner of a profile to remove it from the list.') ?>
<br />
<br />  
<br />
<div id="winks">
    <?php foreach ($privacy_list as $privacy): ?>
        <?php $profile = $privacy->getMemberRelatedByProfileId() ?>
          <div class="privacy_profile_viewers" id="member_profile_<?php echo $profile->getId();?>">
              <h2><?php echo Tools::truncate($profile->getEssayHeadline(), 40) ?></h2><span class="number"><?php echo $profile->getAge() ?></span>
              <div class="input">
                  <span class="public_reg_notice"><?php echo __('Access granted %date%', array('%date%' => distance_of_time_in_words($privacy->getCreatedAt(null)))) ?></span>
                  <?php echo link_to_ref(__('View Profile'), '@profile?bc=hotlist&username=' . $profile->getUsername(), array('class' => 'sec_link')) ?><br />
                  <?php echo link_to_remote(__('Revoke Access'), array(
                                                  'url' => '@toggle_privacy_perm?username=' . $profile->getUsername(),
                                                  'update' => array('success' => 'msg_container'),
                                                  'script' => true, 
                                                  'after' => '$("member_profile_'.$profile->getId().'").remove();'
                                          ), array('class' => 'sec_link', )); ?>
                  <?php echo link_to_remote(image_tag('butt_x.gif', 'class=x'), array(
                                                  'url' => '@toggle_privacy_perm?username=' . $profile->getUsername(),
                                                  'update' => array('success' => 'msg_container'),
                                                  'script' => true, 
                                                  'after' => '$("member_profile_'.$profile->getId().'").remove();'
                                          )); ?>
              </div>
              <?php echo link_to_ref(profile_photo($profile), '@profile?bc=hotlist&username=' . $profile->getUsername()) ?>
          </div>        
    <?php endforeach; ?>
</div>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>