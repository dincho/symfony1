<?php echo __('Member stories instructions', array('%URL_FOR_POST_YOUR_STORY%' => url_for('memberStories/postYourStory'))); ?>
<?php /*
<br /><br />
<style type="text/css">
@import url(http://www.google.com/cse/api/branding.css);
#res { width: 200px; }

</style>
<div class="cse-branding-right" style="color:#FFFFFF; margin:0 auto; width: 380px;">
  <div class="cse-branding-form">
    <form action="<?php echo url_for('@member_stories');?>" id="cse-search-box">
      <fieldset>
        <input type="hidden" name="cx" value="partner-pub-3753475194105958:wjrile-n4wu" />
        <input type="hidden" name="cof" value="FORID:10" />
        <input type="hidden" name="ie" value="ISO-8859-1" />
        <input type="text" name="q" size="31" />
        <input type="submit" name="sa" value="<?php echo __('Search'); ?>" class="button"/>
      </fieldset>
    </form>
  </div>

  <img src="http://www.google.com/images/poweredby_transparent/poweredby_000000.gif" alt="Google" style="margin-top: 12px"/>


</div>

<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 400;
  var googleSearchDomain = "www.google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>


*/ ?>


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
