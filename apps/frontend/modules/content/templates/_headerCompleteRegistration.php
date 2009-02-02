<?php if( $sf_user->isAuthenticated() && $sf_user->getAttribute('status_id') == MemberStatusPeer::ABANDONED ): ?>
<div id="complete_registration">
    <?php echo __('You may complete your registration by <a href="%URL_FOR_CONTINUE_REGISTRATION%" class="sec_link">clicking here</a>', array('%URL_FOR_CONTINUE_REGISTRATION%' => url_for($sf_user->getProfile()->getContinueRegistrationUrl()))) ?>
</div>
<?php endif; ?>