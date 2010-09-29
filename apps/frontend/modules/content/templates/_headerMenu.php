<?php use_helper('prLink') ?>
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
            <p style="margin-bottom: 2px;">
                <span class="username"><?php echo __('Hi %username%', array('%username%' => $sf_user->getProfile()->getUsername())) ?></span>
                <?php echo pr_link_to(__('Dashboard'), 'dashboard/index') ?>&bull;<?php echo pr_link_to(__('Search'), 'search/index') ?>&bull;<?php echo pr_link_to(__('Messages ( %count% )', array('%count%' => $sf_user->getProfile()->getUnreadMessagesCount())), 'messages/index', 'class=last') ?>
                &bull;<?php echo link_to(__('Settings'), '#', array('onclick' => 'slidedown_showHide();return false;')) ?>&bull;
                <?php echo link_to(image_tag($sf_user->getCulture().'/sign_out.gif'), 'profile/signout') ?>
            </p>
        </div>
        <div id="dhtmlgoodies_contentBox">
          <div id="dhtmlgoodies_content">
            <ul class="top">
                <li><strong><?php echo __('Your Profile') ?></strong></li>
                <li><?php echo link_to(__('Registration'), 'editProfile/registration', array('class' => 'sec_link')) ?> <span><?php echo __('(email, etc.)') ?></span></li>
                <li><?php echo link_to(__('Self-description'), 'editProfile/selfDescription', array('class' => 'sec_link')) ?></li>
                <li><?php echo link_to(__('Search Criteria (preferences)'), 'dashboard/searchCriteria', array('class' => 'sec_link')) ?></li>
                <li><?php echo link_to(__('Posing/Essay'), 'editProfile/essay', array('class' => 'sec_link')) ?></li>
                <li><?php echo link_to(__('Photos'), 'editProfile/photos', array('class' => 'sec_link')) ?></li>
                  <?php if( !sfConfig::get('app_settings_imbra_disable') && $sf_user->getProfile()->getUsCitizen() == 1 ): ?>
                      <li><?php echo link_to(__('IMBRA Information'), 'IMBRA/index', array('class' => 'sec_link')) ?></li>
                  <?php endif; ?>
                <?php if( in_array($sf_user->getProfile()->getMemberStatusId(), array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) ): ?>
                    <li><?php echo link_to(__('Activate profile (show)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
                <?php elseif( $sf_user->getProfile()->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
                    <li><?php echo link_to(__('Deactivate profile (hide)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
                <?php endif; ?>
            </ul>
            <ul class="left">
                <li><strong><?php echo __('Your Account') ?></strong></li>
                <li><?php echo link_to(__('Email notifications'), 'dashboard/emailNotifications', array('class' => 'sec_link')) ?></li>
                <li>
                    <?php if( $sf_user->getProfile()->isFree() ): ?>
                        <?php echo link_to(__('Subscribe'), 'subscription/index', array('class' => 'sec_link')) ?>
                    <?php else: ?>
                        <?php echo link_to(__('Manage Subscription'), 'subscription/manage', array('class' => 'sec_link')) ?>
                    <?php endif; ?>
                </li>
                <li><?php echo link_to(__('Privacy'), 'dashboard/privacy', array('class' => 'sec_link')) ?></li>
                <li><?php echo link_to(__('Delete your account'), 'dashboard/deleteYourAccount', array('class' => 'sec_link_brown')) ?></li>
            </ul>
            <script type="text/javascript">
            setSlideDownSpeed(4);
            </script>
        
          </div>
        </div>
      </div> 
        <p class="second_row" ><?php echo pr_link_to(__('Member Stories'), 'memberStories/index') ?>&bull;<?php echo pr_link_to(__('Report a bug'), 'content/reportBug') ?>&bull;<?php if(array_key_exists('help', $links_map)) echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'help', $links_map['help'], '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>

</div>