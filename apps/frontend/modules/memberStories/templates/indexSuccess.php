<?php echo __('Member stories instructions'); ?>

<br /><br />
<form action="http://www.google.com/cse" id="cse-search-box" target="_blank" style="float: right;">
  <fieldset>
    <input type="hidden" name="cx" value="<?php echo sfConfig::get('app_cse_id_' . $sf_user->getCulture()); ?>" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="31" />
    <input type="submit" name="sa" value="<?php echo __('Search'); ?>" class="button" />
  </fieldset>
  <sup style="padding-left: 5px;"><?php echo __('Powered by');?></sup><?php echo image_tag("http://www.google.com/images/poweredby_transparent/poweredby_000000.gif"); ?>
</form>

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
