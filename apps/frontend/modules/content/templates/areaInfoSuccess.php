<div class="float-left" style="margin-right: 10px">
    <?php foreach($geo->getGeoPhotos() as $photo): ?>
        <?php echo image_tag($photo->getImageUrlPath('file')) ?><br /><br />
    <?php endforeach; ?>
</div>

<div class="city_right">
    <?php echo $geo->getInfo(ESC_RAW) ?><br /><br />
    
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