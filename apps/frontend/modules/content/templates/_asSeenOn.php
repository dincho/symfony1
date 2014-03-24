<?php if(count($asSeenOnLogos) > 0): ?>
	<?php echo __('As Seen On') ?>
	<?php foreach ($asSeenOnLogos as $logo):?>
		<span>
		 <?php echo image_tag( '/uploads/images/AsSeenOn/'.$logo->getFile() ) ?>
		</span>
	<?php endforeach;?>
<?php endif;?>