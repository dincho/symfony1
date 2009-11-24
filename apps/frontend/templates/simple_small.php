<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php /* THIS LAYOUT IS USED FOR WEB VIEW OF EMAILS */ ?>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php require_once(dirname(__FILE__).'/_favicon.inc.php'); ?>

<!--[if IE 6]>
<link rel="stylesheet" type="text/css" media="screen" href="/css/ie6.css" />
<![endif]-->

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
                <?php echo link_to(domain_image_tag('logo.gif'), '@homepage') ?>
            </div>
            <div id="header_text">
                <div id="header_title">
                    <?php echo image_tag('header_text/left.gif', 'class=float-left') ?>
                    <?php echo image_tag('header_text/right.gif', 'class=float-right') ?>
                    <h2>
                        <?php if(has_slot('header_title')): ?>
                            <?php include_slot('header_title') ?>
                        <?php endif; ?>
                    </h2>
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
        <?php include_partial('content/footer_copyright');?>
    </div>
</body>
</html>
