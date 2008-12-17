<div id="member_story_right">
    <div id="member_story_list">
        <ul>
            <?php include_component('memberStories', 'shortList'); ?>
        </ul>
        <?php echo link_to(__('See all stories'), '@member_stories', 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo link_to(__('Post your story'), 'memberStories/postYourStory', 'class=sec_link') ?>
    </div>
    <?php $story_img = 'static/stories/story' . $story->getId() . '.jpg'; ?>
    <?php if( file_exists( sfConfig::get('sf_web_dir') . '/images/' . $story_img ) ): ?>
        <?php echo image_tag($story_img, array('id=member_story_img')) ?>
    <?php endif; ?>
</div>
<div id="member_story_content">
    <?php echo $sf_data->getRaw('story')->getContent(); ?>
</div>

<?php if( !$sf_user->isAuthenticated() ): ?>
    <?php echo link_to(__('Join the site now and browse Polish singles for free'), 'registration/joinNow', array('class' => 'sec_link')) ?>
<?php endif; ?>

<?php slot('header_title') ?>
    <?php echo $story->getTitle() ?>
<?php end_slot(); ?>