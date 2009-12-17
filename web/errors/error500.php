<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="Internal Server Error" />
<meta name="robots" content="noindex, nofollow" />
<meta name="language" content="en" />
<title>Internal Server Error</title>

<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/main.css" />

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
                <img alt="Logo" src="<?php echo $path ?>/images/logo.gif" style="width: 104px; height: 51px;"/>
            </div>

            <div id="header_text">
                <div id="header_title">
                    <img alt="left" src="<?php echo $path ?>/images/header_text/left.gif" class="float-left" />
                    <img alt="right" src="<?php echo $path ?>/images/header_text/right.gif" class="float-right" />
                    <h2 style="float:none;">Oops! An Error Occurred</h2>
                </div>
            </div>

            <div id="secondary_container">
                <h3>The server returned a "500 Internal Server Error".</h3>
                
                <p></p>
                <p>Something is broken. Please 

                <script language="JavaScript">
                    document.write("<a href=\"mailto:admin@polishdate.com?subject=PolishDate.com - Internal Server Error&body=URL: " + encodeURIComponent(window.location) + "\">e-mail us</a>");
                </script>
                and let us know what you were doing when this error occurred. We will fix it as soon as possible.
                Sorry for any inconvenience caused.</p>

                <br /><br />
                <p>What's next</p>
                <ul class="sfTIconList">
                    <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
                    <li class="sfTLinkMessage"><a href="/">Go to Homepage</a></li>
                </ul>
            </div>
        </div>
        <!--- end of box border -->
        &nbsp;</div></div></div></div>
        </div></div></div></div>
        <!-- -->
    </div>
</body>
</html>
