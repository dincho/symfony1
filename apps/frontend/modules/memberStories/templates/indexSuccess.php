These are stories written by our members. If you want to share your story with others, please <?php echo link_to(__('post it here'), 'memberStories/postYourStory', 'class=sec_link') ?>
<ul id="member_stories_ul">
<?php foreach ($stories as $story): ?>
    <li><?php echo link_to($story->getLinkName(), '@member_story_by_slug?slug=' . $story->getSlug()) ?></li>
<?php endforeach; ?>
</ul>
<?php if( $sf_user->isAuthenticated() ): ?>
    <?php slot('footer_menu') ?>
        <?php include_partial('content/footer_menu') ?>
    <?php end_slot(); ?>
<?php else: ?>
    <?php //echo link_to(__('Join the site now and browse Polish singles for free'), 'registration/joinNow', array('class' => 'sec_link')) ?>
<?php endif; ?>