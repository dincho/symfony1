<?php use_helper('prLink', 'Javascript') ?>
<?php $links_map = StaticPagePeer::getLinskMap($sf_user->getCatalogId()); ?>

<div id="right">
    <?php if( !$sf_user->isAuthenticated()): ?>
        <p>
            <?php echo pr_link_to(__('Join Now'), 'registration/joinNow') ?>&bull;<?php echo pr_link_to(__('Members Stories'), 'memberStories/index') ?>&bull;<?php echo pr_link_to(__('Home'), '@homepage', 'class=last') ?>
            <?php if(  $sf_context->getModuleName() != sfConfig::get('sf_login_module') 
                      && $sf_context->getActionName() != sfConfig::get('sf_login_action') ): ?>
                      <?php echo link_to(image_tag($sf_user->getCulture().'/sign_in.gif'), 'profile/signIn') ?>
            <?php endif; ?>
        </p>
    <?php else: ?>
      <div id="dhtmlgoodies_slidedown">
         <div id="dhtmlgoodies_control">
          <ul>
            <li class="username"><?php echo __('Hi %username%', array('%username%' => $sf_user->getProfile()->getUsername())) ?></li>
            <li><?php echo pr_link_to(__('Dashboard'), 'dashboard/index') ?></li>
            <li>&bull;</li>
            <li><?php echo pr_link_to(__('Search'), 'search/index') ?></li>
            <li>&bull;</li>
            <li><?php echo pr_link_to(__('Messages ( %count%/%count_all% )', array('%count%' => $sf_user->getProfile()->getUnreadMessagesCount(), '%count_all%' => $sf_user->getProfile()->getAllMessagesCount())), 'messages/index', 'class=last') ?></li>
            <li>&bull;</li>
            <li id="dhtmlgoodies_menu" class="dhtmlgoodiesmenu"><?php echo link_to(__('Settings').image_tag('down.png', array('class' => 'image_down')), '#', array('id' => 'header_menu_drop')); ?></li>
            <li>&nbsp;</li>
            <li><?php echo link_to(image_tag($sf_user->getCulture().'/sign_out.gif'), 'profile/signout') ?></li>
          </ul>
        </div>
        <div id="dhtmlgoodies_contentBox">
          <div id="dhtmlgoodies_content">
            <ul>
                <li><strong><?php echo __('Your Profile') ?></strong></li>
                <li class="menu_item"><?php echo link_to(__('Your Profile (View Your profile as others see it)'), '@my_profile') ?></li>
                <li class="menu_item"><?php echo link_to(__('Registration'), 'editProfile/registration') ?> <span><?php echo __('(email, etc.)') ?></span></li>
                <li class="menu_item"><?php echo link_to(__('Self-description'), 'editProfile/selfDescription') ?></li>
                <li class="menu_item"><?php echo link_to(__('Search Criteria (preferences)'), 'dashboard/searchCriteria') ?></li>
                <li class="menu_item"><?php echo link_to(__('Posing/Essay'), 'editProfile/essay') ?></li>
                <li class="menu_item"><?php echo link_to(__('Photos'), 'editProfile/photos') ?></li>
                  <?php if( !sfConfig::get('app_settings_imbra_disable') && $sf_user->getProfile()->getUsCitizen() == 1 ): ?>
                      <li class="menu_item"><?php echo link_to(__('IMBRA Information'), 'IMBRA/index') ?></li>
                  <?php endif; ?>
                <?php if( in_array($sf_user->getProfile()->getMemberStatusId(), array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) ): ?>
                    <li class="menu_item"><?php echo link_to(__('Activate profile (show)'), 'dashboard/deactivate') ?></li>
                <?php elseif( $sf_user->getProfile()->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
                    <li class="menu_item"><?php echo link_to(__('Deactivate profile (hide)'), 'dashboard/deactivate') ?></li>
                <?php endif; ?>
            </ul>
            <ul>
                <li><strong><?php echo __('Your Account') ?></strong></li>
                <li class="menu_item"><?php echo link_to(__('Email notifications'), 'dashboard/emailNotifications') ?></li>
                <li class="menu_item">
                    <?php if( $sf_user->getProfile()->isFree() ): ?>
                        <?php echo link_to(__('Subscribe'), 'subscription/index') ?>
                    <?php else: ?>
                        <?php echo link_to(__('Manage Subscription'), 'subscription/manage') ?>
                    <?php endif; ?>
                </li>
                <li class="menu_item"><?php echo link_to(__('Privacy'), 'dashboard/privacy') ?></li>
                <li class="menu_item"><?php echo link_to(__('Delete your account'), 'dashboard/deleteYourAccount', array('class' => 'sec_link_brown')) ?></li>
            </ul>
          </div>
        </div>
      </div> 
        <p class="second_row" ><?php echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'safety_tips', $links_map['safety_tips'], '@page?slug=safety_tips', 'class=last') ?>
          &bull;<?php echo pr_link_to(__('Report a bug'), 'content/reportBug') ?>
          &bull;<?php if(array_key_exists('help', $links_map)) echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'help', $links_map['help'], '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>
</div>
