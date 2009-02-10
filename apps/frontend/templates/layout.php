<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
    <?php if( $sf_user->isAuthenticated() && 
              $sf_user->getAttribute('status_id') == MemberStatusPeer::ABANDONED && 
              $sf_context->getModuleName() != 'IMBRA' && 
              !$sf_user->getAttribute('must_confirm_email')): ?>
        <?php include_partial('content/headerCompleteRegistration'); ?>
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
                    <?php echo link_to(image_tag('polish_romance_small.gif'), '@homepage') ?>
                </div>
                <?php include_component('content','headerMenu', array('username' => $sf_user->getUsername(), 'auth' => $sf_user->isAuthenticated())); ?>
            </div>
            <?php if( $sf_data->get('sf_flash')->has('msg_error') || 
                      $sf_data->get('sf_flash')->has('msg_warning') || 
                      $sf_data->get('sf_flash')->has('msg_ok') || 
                      $sf_data->get('sf_flash')->has('msg_info') ): ?>
                <?php include_partial('content/messages'); ?>
            <?php endif; ?>
            
            <?php include_partial('content/formErrors'); ?>          
            <?php include_component('content', 'breadcrumb', array('header_title' => @$header_title)); ?>
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
    <?php include_component('content', 'footer'); ?>
    <span class="footer_footer">
        <?php echo __('<a href="%URL_FOR_COPYRIGHT%">Copyright 2007-2009 by PolishRomance.com %VERSION%</a>- Patent Pending - All Rights Reserved', array('%VERSION%' => sfConfig::get('app_version'))) ?> 
        &nbsp;-&nbsp;<?php include_partial('system/page_execution'); ?>
    </span>
</body>
</html>
