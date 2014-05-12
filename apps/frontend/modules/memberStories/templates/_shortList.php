            <?php foreach($stories_list as $story_list): ?>
            <li><?php echo link_to(Tools::truncate($story_list->getLinkName(), 40), '@member_story_by_slug?slug=' . $story_list->getSlug(), array('class' => 'sec_link')) ?></li>
            <?php endforeach; ?>
