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
                <li><strong><?php echo __('See profiles in your area:') ?></strong></li>
                <li><?php echo link_to(__('Newly registered'), 'search/mostRecent', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
                <li><?php echo link_to(__('Most recent visitors'), 'search/lastLogin', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
                <li><?php echo link_to(__('Best matching you'), 'search/criteria', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
                <li><?php echo link_to(__('You match them best'), 'search/reverse', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
                <li><?php echo link_to(__('Best mutual matches'), 'search/matches', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
                <li><?php echo link_to(__('Per your own rating'), 'search/byRate', array('class' => 'sec_link', 'query_string' =>'filters[location]=1')) ?></li>
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