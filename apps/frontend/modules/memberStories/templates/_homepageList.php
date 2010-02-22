<?php foreach($stories_list as $i => $story): ?>
    <li><?php echo (($i != 0) ? '&bull;' : ''). link_to(Tools::truncate($story->getLinkName(), 40), '@member_story_by_slug?slug=' . $story->getSlug(), array('class' => 'sec_link')) ?></li>
<?php endforeach; ?>