<div id="member_story_right">
    <div id="member_story_list">
        <ul>
            <?php include_component('memberStories', 'shortList'); ?>
        </ul>
        <?php echo link_to(__('See all stories'), '@member_stories', 'class=sec_link') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo link_to(__('Post your story'), 'memberStories/postYourStory', 'class=sec_link') ?>
    </div>
    <?php if( $story->getStockPhotoId() ): ?>
        <?php $stockPhoto = $story->getStockPhoto() ?>
        <?php $img_tag = image_tag(($stockPhoto->getImageFilename('cropped') ? $stockPhoto->getImageUrlPath('cropped', '220x225') : $stockPhoto->getImageUrlPath('file', '220x225')), array('id' => 'member_story_img')) ?>

      <?php if( $sf_user->isAuthenticated()): ?>
        <?php echo link_to($img_tag,  '@matches') ?>
      <?php else: ?>
          <?php if( sfConfig::get('app_beta_period') ): ?>
              <?php echo link_to($img_tag, 'registration/joinNow') ?>
          <?php else: ?>
              <?php $looking_for = ( $stockPhoto->getGender() == 'M') ? 'F_M' : 'M_F'; ?>
              <?php echo link_to($img_tag,  'search/public?filter=filter&filters[looking_for]=' . $looking_for) ?>
          <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>
    
    <br /><br />
    <div class="g_ad">
        <script type="text/javascript">
        <!--
            google_ad_client = "pub-3753475194105958";
            /* 160x600 PD/ LS Member Stories */
            google_ad_slot = "3396883494";
            google_ad_width = 160;
            google_ad_height = 600;
        //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
    </div>
</div>
<div id="member_story_content">
    <?php echo $sf_data->getRaw('story')->getContent(); ?>
</div>

<?php slot('header_title') ?>
    <?php echo $story->getTitle(ESC_RAW) ?>
<?php end_slot(); ?>