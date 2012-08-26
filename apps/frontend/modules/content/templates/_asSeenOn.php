<?php if(count($asSeenOnLogos) > 0): ?>
	<h1>As Seen On</h1>
	<ul>
	<?php foreach ($asSeenOnLogos as $logo):?>
		<li style="margin-right: 20px; display: inline;">
		 <?php echo image_tag( '/uploads/images/AsSeenOn/'.$logo->getFile() ) ?>
		</li> 
	<?php endforeach;?>
	</ul>
<?php endif;?>