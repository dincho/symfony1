<?php use_helper('prLink') ?>
<?php $links_map = StaticPagePeer::getLinskMap(); ?>

<div id="right">
    <?php if( !$sf_user->isAuthenticated()): ?>
        <p>
            <?php echo pr_link_to(__('Join Now'), 'registration/joinNow') ?>&bull;<?php echo pr_link_to(__('Members Stories'), '@member_stories') ?>&bull;<?php echo pr_link_to(__('Home'), '@homepage', 'class=last') ?>
            <?php $current_culture = ($sf_user->getCulture() == 'pl') ? 'pl' : 'en'; ?>
            <?php if( $current_culture == "en" ): ?>
                <?php echo link_to(image_tag('sign_in.gif'), 'profile/signIn') ?>
            <?php else: ?>
                <?php echo link_to(image_tag('sign_in_pl.gif'), 'profile/signIn') ?>
            <?php endif; ?>
        </p>
    <?php else: ?>
        <p style="margin-bottom: 2px;">
            <span class="username"><?php echo __('Hi %username%', array('%username%' => $sf_user->getProfile()->getUsername())) ?></span>
            <?php echo pr_link_to(__('Dashboard'), 'dashboard/index') ?>&bull;<?php echo pr_link_to(__('Search'), 'search/index') ?>&bull;<?php echo pr_link_to(__('Messages'), 'messages/index', 'class=last') ?>
            <?php $current_culture = ($sf_user->getCulture() == 'pl') ? 'pl' : 'en'; ?>
            <?php if( $current_culture == "en" ): ?>
                <?php echo link_to(image_tag('sign_out.gif'), 'profile/signout') ?>
            <?php else: ?>
                <?php echo link_to(image_tag('sign_out_pl.gif'), 'profile/signout') ?>
            <?php endif; ?>
        </p>
        <p class="second_row" style="margin-top: 4px;"><?php echo pr_link_to(__('Member Stories'), 'memberStories/index') ?>&bull;<?php echo pr_link_to(__('Report a bug'), 'content/reportBug') ?>&bull;<?php if(array_key_exists('help', $links_map)) echo link_to_unless( $sf_context->getModuleName() == 'content' && $sf_request->getParameter('slug') == 'help', $links_map['help'], '@page?slug=help', 'class=last') ?></p>
    <?php endif; ?>
</div>