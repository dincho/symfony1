<div id="right">
    <?php if( !$sf_user->isAuthenticated()): ?>
        <?php echo link_to('Join Now', 'registration/joinNow') ?>&bull;<?php echo link_to('Members Stories', '@member_stories') ?>&bull;<?php echo link_to('Home', '@homepage', 'class=last') ?>
        <?php echo link_to(image_tag('sign_in.gif'), 'profile/signIn') ?>
    <?php else: ?>
        <span><?php echo __('Hi %username%', array('%username%' => $sf_user->getProfile()->getUsername())) ?></span>
        <?php echo link_to('Dashboard', 'dashboard/index') ?>&bull;<?php echo link_to('Search', 'search/index') ?>&bull;<?php echo link_to('Messages', 'messages/index', 'class=last') ?>
        <?php echo link_to(image_tag('sign_out.gif'), 'profile/signout') ?>
        <p><?php echo link_to('Member Stories', '@member_stories') ?>&bull;<?php echo link_to('Report a bug', 'content/reportBug') ?>&bull;<?php echo link_to('Help', '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>
</div>