<?php echo __('Member stories instructions', array('%URL_FOR_POST_YOUR_STORY%' => url_for('memberStories/postYourStory'))); ?>

<ul id="member_stories_ul">
<?php foreach ($stories as $story): ?>
    <li>
        <?php echo link_to($story->getLinkName(), '@member_story_by_slug?slug=' . $story->getSlug()) ?>
        <?php if ($story->getSummary()): ?>
            <br /><?php echo $story->getSummary() ?>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>
