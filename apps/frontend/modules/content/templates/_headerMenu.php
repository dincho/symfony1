<?php use_helper('prLink', 'Javascript') ?>
<?php $links_map = StaticPagePeer::getLinskMap($sf_user->getCatalogId()); ?>

<?php echo javascript_tag("
    function goto_menu(menuItem)
    {
      window.location.href = menuItem.firstChild.href;
    }
    
    
    Event.observe(window, 'load', function(event) {
      Event.observe(document, 'click', function(event) { 
        if(slidedownActive == false && slidedownContentBox != false && slidedownContentBox.style.visibility == 'visible' )
          slidedown_showHide();
      })
    });
    
    if (!window.XMLHttpRequest)
	  {
	    Event.observe(window, 'load', function() {
	        $$('#dhtmlgoodies_contentBox  .menu_item').each( function(e) {
	            Event.observe(e, 'mouseover', function() {
	                Element.addClassName(e, 'hover');
	            });
	            Event.observe(e, 'mouseout', function() {
	                Element.removeClassName(e, 'hover');
	            });
	        });
	    });
	}
");?>
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
            <li>&bull;<li>
            <li><?php echo pr_link_to(__('Search'), 'search/index') ?></li>
            <li>&bull;<li>
            <li><?php echo pr_link_to(__('Messages ( %count% )', array('%count%' => $sf_user->getProfile()->getUnreadMessagesCount())), 'messages/index', 'class=last') ?></li>
            <li>&bull;<li>
            <li id="dhtmlgoodies_menu" class="dhtmlgoodiesmenu"><?php echo link_to(__('Settings').image_tag('down.png', array('class' => 'image_down')), '#', array('onclick' => 'slidedown_showHide(); return false;')) ?></li>
            <li>&bull;<li>
            <li><?php echo link_to(image_tag($sf_user->getCulture().'/sign_out.gif'), 'profile/signout') ?></li>
          </ul>
        </div>
        <div id="dhtmlgoodies_contentBox">
          <div id="dhtmlgoodies_content">
            <ul>
                <li><strong><?php echo __('Your Profile') ?></strong></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Registration'), 'editProfile/registration', array('class' => 'sec_link')) ?> <span><?php echo __('(email, etc.)') ?></span></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Self-description'), 'editProfile/selfDescription', array('class' => 'sec_link')) ?></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Search Criteria (preferences)'), 'dashboard/searchCriteria', array('class' => 'sec_link')) ?></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Posing/Essay'), 'editProfile/essay', array('class' => 'sec_link')) ?></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Photos'), 'editProfile/photos', array('class' => 'sec_link')) ?></li>
                  <?php if( !sfConfig::get('app_settings_imbra_disable') && $sf_user->getProfile()->getUsCitizen() == 1 ): ?>
                      <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('IMBRA Information'), 'IMBRA/index', array('class' => 'sec_link')) ?></li>
                  <?php endif; ?>
                <?php if( in_array($sf_user->getProfile()->getMemberStatusId(), array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) ): ?>
                    <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Activate profile (show)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
                <?php elseif( $sf_user->getProfile()->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
                    <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Deactivate profile (hide)'), 'dashboard/deactivate', array('class' => 'sec_link')) ?></li>
                <?php endif; ?>
            </ul>
            <ul>
                <li><strong><?php echo __('Your Account') ?></strong></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Email notifications'), 'dashboard/emailNotifications', array('class' => 'sec_link')) ?></li>
                <li class="menu_item" onclick="goto_menu(this);">
                    <?php if( $sf_user->getProfile()->isFree() ): ?>
                        <?php echo link_to(__('Subscribe'), 'subscription/index', array('class' => 'sec_link')) ?>
                    <?php else: ?>
                        <?php echo link_to(__('Manage Subscription'), 'subscription/manage', array('class' => 'sec_link')) ?>
                    <?php endif; ?>
                </li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Privacy'), 'dashboard/privacy', array('class' => 'sec_link')) ?></li>
                <li class="menu_item" onclick="goto_menu(this);"><?php echo link_to(__('Delete your account'), 'dashboard/deleteYourAccount', array('class' => 'sec_link_brown')) ?></li>
            </ul>
            <script type="text/javascript">
            setSlideDownSpeed(15);
            </script>
        
          </div>
        </div>
      </div> 
        <p class="second_row" ><?php echo pr_link_to(__('Member Stories'), 'memberStories/index') ?>&bull;<?php echo pr_link_to(__('Report a bug'), 'content/reportBug') ?>&bull;<?php if(array_key_exists('help', $links_map)) echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'help', $links_map['help'], '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>

</div>