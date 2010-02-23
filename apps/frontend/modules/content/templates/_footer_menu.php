<?php if( $sf_user->isAuthenticated() ): ?>
<div id="footer_menu">
    <ul>
        <li><?php echo link_to(__('Matches'), '@matches') ?></li>
        <li><?php echo link_to(__('Messages'), 'messages/index') ?></li>
        <li><?php echo link_to(__('Winks'), '@winks') ?></li>
        <li><?php echo link_to(__('Hotlist'), '@hotlist') ?></li>
        <li><?php echo link_to(__('Visitors'), '@visitors') ?></li>
        <li><?php echo link_to(__('Blocked Members'), '@blocked_members') ?></li>
    </ul>
    <ul>
        <li><?php echo link_to(__('Registration'), 'editProfile/registration') ?></li>
        <li><?php echo link_to(__('Self-description'), 'editProfile/selfDescription') ?></li>
        <li><?php echo link_to(__('Match criteria (preferences)'), 'dashboard/searchCriteria') ?></li>
        <li><?php echo link_to(__('Posting/Essay'), 'editProfile/essay') ?></li>
        <li><?php echo link_to(__('Photos'), 'editProfile/photos') ?></li>
        <?php if( !sfConfig::get('app_settings_imbra_disable') ): ?>
          <li><?php echo link_to(__('IMBRA information'), 'IMBRA/index') ?></li>
        <?php endif; ?>
        <?php if( in_array($sf_user->getProfile()->getMemberStatusId(), array(MemberStatusPeer::DEACTIVATED, MemberStatusPeer::DEACTIVATED_AUTO)) ): ?>
            <li><?php echo link_to(__('Activate profile (show)'), 'dashboard/deactivate') ?></li>
        <?php elseif( $sf_user->getProfile()->getMemberStatusId() == MemberStatusPeer::ACTIVE ): ?>
            <li><?php echo link_to(__('Deactivate profile (hide)'), 'dashboard/deactivate') ?></li>
        <?php endif; ?>
    </ul>
    <ul>
        <li><?php echo link_to(__('Email notifications'), 'dashboard/emailNotifications') ?></li>
        <li>
            <?php if( $sf_user->getProfile()->getSubscriptionId() == SubscriptionPeer::FREE ): ?>
                <?php echo link_to(__('Subscribe'), 'subscription/index') ?>
            <?php else: ?>
                <?php echo link_to(__('Manage Subscription'), 'subscription/manage') ?>
            <?php endif; ?>
        </li>
        <li><?php echo link_to(__('Privacy'), 'dashboard/privacy') ?></li>
        <li><?php echo link_to(__('Delete your account'), 'dashboard/deleteYourAccount') ?></li>
    </ul>
</div>
<?php endif; ?>