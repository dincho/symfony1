<div id="member_story_right">
    <div id="member_story_list">
        <ul>
            <?php include_component('memberStories', 'shortList'); ?>
        </ul>
        <?php echo link_to(__('See all stories'), '@member_stories', 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo link_to(__('Post your story'), 'memberStories/postYourStory', 'class=sec_link') ?>
    </div>
    <?php echo image_tag('static/stories/story' . $story->getId() . '.jpg', array('id=member_story_img')) ?>
</div>
<?php echo $sf_data->getRaw('story')->getContent(); ?>
<br />
<?php echo link_to(__('Join the site now and browse Polish singles for free'), 'registration/joinNow', array('class' => 'sec_link')) ?>