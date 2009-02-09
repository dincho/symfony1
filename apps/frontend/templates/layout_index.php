<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>

<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

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
    <?php include_component('content', 'footer'); ?>
    <span class="footer_footer">
        <?php echo __('<a href="%URL_FOR_COPYRIGHT%">Copyright 2007-2009 by PolishRomance.com %VERSION%</a>- Patent Pending - All Rights Reserved', array('%VERSION%' => sfConfig::get('app_version'))) ?> 
        &nbsp;-&nbsp;<?php include_partial('system/page_execution'); ?>
    </span>    
</body>
</html>
