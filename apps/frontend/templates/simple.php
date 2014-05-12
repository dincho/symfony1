<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php /* THIS LAYOUT IS USED FOR SIMPLE ACTIONS LIKE REGISTRATION, SIMPLE MESSAGES AND ETC. */ ?>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>
<?php require_once(dirname(__FILE__).'/_favicon.inc.php'); ?>

</head>
<body>
    <noscript>
        <div id="noscript-padding"></div>
    </noscript>
    <div id="box">
        <!--- box border -->
        <div id="lb"><div id="rb">
        <div id="bb"><div id="blc">
        <div id="brc"><div id="tb">
        <div id="tlc"><div id="trc">&nbsp;
        <!--  -->
        <div id="content">
            <div id="header">
                    <?php echo link_to(domain_image_tag('logo.gif'), '@homepage', array('style' => @$logo_style)) ?>
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
    <div id="footer">
        <?php include_partial('content/footer_links'); ?>
        <?php include_partial('content/footer_copyright');?>
    </div>
    <?php include_partial('content/javascriptWarning'); ?>
</body>
</html>
