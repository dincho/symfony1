<div class="membership">
    <?php if( $member->getSubscriptionId() == SubscriptionPeer::PREMIUM ): ?>
      <?php echo link_to(image_tag($sf_user->getCulture().'/full_member.gif'), 'subscription/index') ?>
    <?php elseif( $member->getSubscriptionId() == SubscriptionPeer::VIP ): ?>
      <?php echo link_to(image_tag($sf_user->getCulture().'/vip_member.gif'), 'subscription/index') ?>
    <?php elseif(sfConfig::get('app_settings_enable_gifts')): ?>
      <?php echo image_tag($sf_user->getCulture().'/buy_gift_' . $member->getSex() . '.gif'); ?>
    <?php endif; ?>
</div>
