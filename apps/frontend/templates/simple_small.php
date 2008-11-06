<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php /* THIS LAYOUT IS USED FOR WEB VIEW OF EMAILS */ ?>

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
                <?php echo link_to(image_tag('polish_romance_small.gif'), '@homepage') ?>
            </div>
            <div id="header_text">
                <div id="header_title">
                    <?php echo image_tag('header_text/left.gif', 'class=float-left') ?>
                    <?php echo image_tag('header_text/right.gif', 'class=float-right') ?>
                    <h2><?php if ( isset($header_title) ) echo $header_title ?></h2>
                </div>
            </div>
            <div id="secondary_container">
                <?php echo $sf_data->getRaw('sf_content') ?>
            </div>
        </div>
        <!--- end of box border -->
        &nbsp;</div></div></div></div>
        </div></div></div></div>
        <!-- -->
    </div>
    <div id="footer">
        <span class="footer_footer"><?php echo link_to(__('&copy; Copyright 2007-2008 by PolishRomance.com'), '@page?slug=copyright') ?> - Patent Pending - All Rights Reserved</span>
    </div>
</body>
</html>
