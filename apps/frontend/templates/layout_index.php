<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php require_once(dirname(__FILE__).'/_favicon.inc.php'); ?>

</head>
<body>
    <?php if( $sf_user->isAuthenticated() && $sf_user->getAttribute('status_id') == MemberStatusPeer::ABANDONED ): ?>
        <?php include_partial('content/headerCompleteRegistration'); ?>
    <?php endif; ?>
    <div id="box-index">              
        <!--- box border -->
        <div id="lb"><div id="rb">
        <div id="bb"><div id="blc">
        <div id="brc"><div id="tb">
        <div id="tlc"><div id="trc">&nbsp;
        <!--  -->   
        <div id="content">  
            <?php echo $sf_data->getRaw('sf_content') ?>
        </div>
        <!--- end of box border -->
        </div></div></div></div>
        </div></div></div></div>
        <!-- -->
    </div>
    <div id="footer">
        <?php include_partial('content/footer_links'); ?>
        <?php include_partial('content/footer_copyright');?>
        <?php include_component('content','asSeenOn');?>
    </div>
    <div id="footer_articles">
        <ul>
            <?php include_component('memberStories', 'homepageList'); ?>
        </ul>
        <?php echo __('Homepage footer articles'); ?>
    </div>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/<?php echo ($sf_user->getCulture() == 'pl') ? 'pl_PL' : 'en_US'; ?>/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
