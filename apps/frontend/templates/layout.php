<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php require_once(dirname(__FILE__).'/_favicon.inc.php'); ?>
</head>

<body>
    <noscript>
        <div id="noscript-padding"></div>
    </noscript>
    <?php if( $sf_user->isAuthenticated() && 
              $sf_user->getAttribute('status_id') == MemberStatusPeer::ABANDONED && 
              $sf_context->getModuleName() != 'IMBRA' && 
              !$sf_user->getAttribute('must_confirm_email')): ?>
        <?php include_partial('content/headerCompleteRegistration'); ?>
    <?php endif; ?>
    <?php if( $sf_user->isAuthenticated() &&
              $sf_user->getProfile()->getPrivateDating()): ?> 
        <?php include_partial('content/headerInPrivateDate'); ?>
    <?php endif; ?>
    <div id="box">
        <!--- box border -->
        <div id="lb"><div id="rb">
        <div id="bb"><div id="blc">
        <div id="brc"><div id="tb">
        <div id="tlc"><div id="trc">&nbsp;
        <!--  -->   
        <div id="content">  
            <div id="header">
                <div id="left">
                    <?php echo link_to(domain_image_tag('logo.gif'), '@homepage') ?>
                </div>
                <?php include_component('content','headerMenu', array('username' => $sf_user->getUsername(), 'auth' => $sf_user->isAuthenticated())); ?>
            </div>
            <div id="msg_container">
                <?php if( $sf_data->get('sf_flash')->has('msg_error') || 
                          $sf_data->get('sf_flash')->has('msg_warning') || 
                          $sf_data->get('sf_flash')->has('msg_ok') || 
                          $sf_data->get('sf_flash')->has('msg_info') ): ?>
                    <?php include_partial('content/messages'); ?>
                <?php endif; ?>

            
                <?php include_partial('content/formErrors'); ?>
            </div>


            <?php if( $sf_data->get('sf_flash')->has('warning_timeout') ): ?>
              <div id="messageBar"> 
                  &nbsp;&nbsp;&nbsp;
                  <?php echo ( $sf_flash->has('msg_no_i18n') ) ? $sf_flash->get('warning_timeout', ESC_RAW) : __($sf_flash->get('warning_timeout', ESC_RAW)); ?>
                  &nbsp;&nbsp;&nbsp;
                </div>
            <?php endif; ?>
                   
                        
            <?php if( stripos(sfRouting::getInstance()->getCurrentInternalUri(), 'myProfile') !== false ): //looking my profile ?>
              <?php $breadcrumb_params = array('header_title' => @$header_title, 'auth' => $sf_user->isAuthenticated(), 'sf_cache_key' => $sf_user->getId()); ?>
            <?php else: //other's profiles ?>
              <?php $breadcrumb_params = array('header_title' => @$header_title, 'auth' => $sf_user->isAuthenticated()); ?>
            <?php endif; ?>
              
            <?php include_component('content', 'breadcrumb', $breadcrumb_params); ?>
            <div id="secondary_container">
                <?php echo $sf_data->getRaw('sf_content') ?>
            </div>
            <?php if (has_slot('footer_menu')): ?>
              <?php include_slot('footer_menu') ?>
            <?php endif; ?>
        </div>
        <!--- end of box border -->
        &nbsp;</div></div></div></div>
        </div></div></div></div>
        <!-- -->
    </div>
    <div id="footer">
        <?php include_partial('content/footer_links'); ?>
        <?php include_partial('content/footer_copyright');?>
    </div>
    <?php include_partial('content/javascriptWarning'); ?>
    <?php if( $sf_user->isAuthenticated() ): ?>
      <?php include_component('content', 'notifications') ?>
      <?php include_partial('content/timeout_warning'); ?>
    <?php endif; ?>
    <div id="fb-root"></div>
    <script type="text/javascript">(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/<?php echo ($sf_user->getCulture() == 'pl') ? 'pl_PL' : 'en_US'; ?>/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- Google Code for Remarketing Tag -->
    <script type="text/javascript">
      /* <![CDATA[ */
      var google_conversion_id = 1064048011;
      var google_custom_params = window.google_tag_params;
      var google_remarketing_only = true;
      /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <noscript>
      <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1064048011/?value=0&amp;guid=ON&amp;script=0"/>
      </div>
    </noscript>
</body>
</html>
