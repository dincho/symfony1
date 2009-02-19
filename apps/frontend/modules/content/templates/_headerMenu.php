<?php use_helper('prLink') ?>
<?php $links_map = StaticPagePeer::getLinskMap(); ?>

<div id="right">
    <?php if( !$sf_user->isAuthenticated()): ?>
        <p>
            <?php echo pr_link_to('Join Now', 'registration/joinNow') ?>&bull;<?php echo pr_link_to('Members Stories', '@member_stories') ?>&bull;<?php echo pr_link_to('Home', '@homepage', 'class=last') ?>
            <?php echo link_to(image_tag('sign_in.gif'), 'profile/signIn') ?>
        </p>
    <?php else: ?>
        <p style="margin-bottom: 2px;">
            <span class="username"><?php echo __('Hi %username%', array('%username%' => $sf_user->getProfile()->getUsername())) ?></span>
            <?php echo pr_link_to('Dashboard', 'dashboard/index') ?>&bull;<?php echo pr_link_to('Search', 'search/index') ?>&bull;<?php echo pr_link_to('Messages', 'messages/index', 'class=last') ?>
            <?php echo link_to(image_tag('sign_out.gif'), 'profile/signout') ?>
        </p>
        <p class="second_row" style="margin-top: 4px;"><?php echo pr_link_to('Member Stories', 'memberStories/index') ?>&bull;<?php echo pr_link_to('Report a bug', 'content/reportBug') ?>&bull;<?php if(array_key_exists('help', $links_map)) echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'help', $links_map['help'], '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>
</div>