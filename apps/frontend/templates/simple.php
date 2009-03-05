<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php /* THIS LAYOUT IS USED FOR SIMPLE ACTIONS LIKE REGISTRATION, SIMPLE MESSAGES AND ETC. */ ?>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
    <div id="box">              
        <!--- box border -->
        <div id="lb"><div id="rb">
        <div id="bb"><div id="blc">
        <div id="brc"><div id="tb">
        <div id="tlc"><div id="trc">&nbsp;
        <!--  -->   
        <div id="content">  
            <div id="header">
                    <?php if(has_slot('change_language')): ?>
                        <div id="left" class="index">
                            <?php include_slot('change_language') ?>
                            <?php $logo_style = 'padding-right: 150px' ?>
                        </div>
                    <?php endif; ?> 
                    <?php echo link_to(image_tag('polish_romance_small.gif'), '@homepage', array('style' => @$logo_style)) ?>
            </div>
            <?php if( $sf_data->get('sf_flash')->has('msg_error') || 
                      $sf_data->get('sf_flash')->has('msg_warning') || 
                      $sf_data->get('sf_flash')->has('msg_ok') || 
                      $sf_data->get('sf_flash')->has('msg_info') ): ?>
                <?php include_partial('content/messages'); ?>
            <?php endif; ?>
                      
            <?php include_partial('content/formErrors'); ?>          
            <?php include_component('content', 'breadcrumb', array('header_title' => @$header_title, 'header_current_step' => @$header_current_step, 'header_steps' => @$header_steps)); ?>
            <div id="secondary_container">
                <?php echo $sf_data->getRaw('sf_content') ?>
            </div>
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
