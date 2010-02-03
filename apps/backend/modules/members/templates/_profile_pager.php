<?php $pager = new ProfilePager($sf_user->getAttributeHolder()->getAll('backend/members/profile_pager'), $member->getId()); ?>

<?php if( $pager->hasResults() ): ?>
    <div id="profile_pager">
        <?php echo link_to_unless(is_null($pager->getPrevious()), '&lt;&lt;&nbsp;Previous', 'members/edit?id=' . $pager->getPrevious(), array()) ?>
        <?php echo link_to("Back to List", 'members/list', array('class' => 'sec_link')) ?>
        <?php echo link_to_unless(is_null($pager->getNext()), 'Next&nbsp;&gt;&gt;', 'members/edit?id=' . $pager->getNext(), array()) ?>
    </div>
<?php endif; ?>

