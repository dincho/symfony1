<?php
require_once('libs.inc.php');
$sub = new Subscribe();
$confirmed = '';

if( isset($_POST['email']) && !empty($_POST['email']) && $sub->add($_POST['email']) )
{
  $confirmed = 'Your email address have been subscribed.';
}

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>PolishRomance / Coming Soon</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link type="text/css" rel="stylesheet" href="style.css" media="screen" />
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
			<div id="header" class="index">
				<a href=""><img src="images/polish_romance.gif" alt="logo" border="0"></img></a>
			</div>
			<div id="header_text" class="index">
				Polish Romance is the best place to meet, date or marry Polish women.
			</div>
			<div id="coming_soon">
				<div id="index_image" class="coming_soon">
					<img src="images/coming_soon.jpg" alt="" border="0" />
					<div id="coming_soon_email_block">
						<span class="msg">Want to be notified when the site goes live?</span>
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
						  <?php if( isset($_POST['email']) && !empty($_POST['email']) && $sub->hasError()): ?>
						      <input value="<?php echo $_POST['email'] ?>" name="email" type="text" class="bigfield" />
						  <?php else: ?>
							<input onclick="this.value='';" value="Enter your email address" name="email" type="text" class="bigfield" />
							<?php endif; ?>
							<input type="submit" value="Send" class="send" />
						</form>
					</div>
				</div>
				<?php if( $sub->hasError() ): ?>
				    <p id="message" class="msg_error"><?php echo $sub->getError() ?></p>
				<?php elseif( $confirmed ): ?>
				    <p id="message" class="msg_ok">We've added <?php echo $_POST['email'] ?> to our mailing list.<br />We'll send you a note when we go live. Thanks</p>
				<?php endif; ?>
			</div>
		</div>
		<!--- end of box border -->
		</div></div></div></div>
		</div></div></div></div>
		<!-- -->
	</div>
</body>
</html>