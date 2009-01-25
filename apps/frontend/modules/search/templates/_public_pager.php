<div class="pager">
    <span><?php echo __('Page') ?></span>
    <?php foreach (range(1, 5) as $page): ?>
        <?php echo link_to_unless($page == 1, $page, 'registration/joinNow') ?>
    <?php endforeach; ?>
    <?php echo link_to(image_tag('next.gif'), 'registration/joinNow') ?>
</div>