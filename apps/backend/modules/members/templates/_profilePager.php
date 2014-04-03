<div class="members_header">
    <?php echo button_to(
        'View profile',
        $member->getFrontendProfileUrl(),
        array('popup' => true, 'class' => 'view_profile')
    ) ?>
    <?php echo button_to(
        'Send Email',
        'feedback/compose?username=' . $member->getUsername(),
        'class=float-right'
    ) ?>
    <?php if ($pager->hasResults()): ?>
        <div id="profile_pager">
            <?php echo link_to_unless(
                is_null($pager->getPrevious()),
                '&lt;&lt;&nbsp;Previous',
                'members/edit?id=' . $pager->getPrevious()
            ) ?>
            <?php echo link_to("Back to List", 'members/list', array('class' => 'sec_link')) ?>
            <?php echo link_to_unless(
                is_null($pager->getNext()),
                'Next&nbsp;&gt;&gt;',
                'members/edit?id=' . $pager->getNext()
            ) ?>
        </div>
    <?php endif; ?>
</div>
