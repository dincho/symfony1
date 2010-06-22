<?php if( $details ): ?>
<div class="float-left" style="margin-right: 10px">
    <?php foreach($details->getGeo()->getGeoPhotos() as $photo): ?>
        <?php echo image_tag($photo->getImageUrlPath('file')) ?><br /><br />
    <?php endforeach; ?>
</div>
<?php endif; ?>

<div class="city_right">
    <?php echo __('Area Info Headline', array('%GEO_TREE_STRING%' => $geo_tree_string)); ?><br />
    
    <?php if( $details ): ?>
        <?php echo $details->getMemberInfo(ESC_RAW); ?><br /><br />
    <?php endif; ?>
    
    <br /><br />
    <script type="text/javascript">
        <!--
        google_ad_client = "pub-3753475194105958";
        /* PD|LS Area Info|336x280, created 1/14/10 */
        google_ad_slot = "8483030225";
        google_ad_width = 336;
        google_ad_height = 280;
        //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>

<br class="clear" />