<div id="photos">

<?php echo form_tag('photos/asSeenOnLogos', array('multipart' => true)) ?>
    <fieldset>
        <div class="legend"><?php echo isset($photo) ? 'Edit Logo' : 'Upload New Logo' ?></div>
        
        <?php if(isset($photo)):?>
        	 <?php echo image_tag( '/uploads/images/AsSeenOn/'.$photo->getFile() ) ?><br />
        	 <input type="hidden" name="logo_id" value="<?php echo $photo->getId()?>" />
        <?php endif;?>
        
        <?php echo input_file_tag('new_photo') ?>
        
        <table class="zebra" style="width: 300px; margin:20px 0;">
        <tr>
            <th colspan="2">Languages</th>
        </tr>
        <?php foreach($catalogs as $catalog): ?>
            <tr>
                <td style="width:5px; padding: 0;"><?php echo checkbox_tag('catalogs[]', $catalog->getCatId(), in_array($catalog->getCatId(), $asSeen)) ?></td>
                <td><?php echo $catalog; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
        <?php echo submit_tag('Save') ?><br />
    </fieldset>
</form>


    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/asSeenOnLogos')); ?><br />
    
    <fieldset class="form_fields">
    <?php $i=1; foreach($pager->getResults() as $photo): ?>
        <div class="photo_slot">
            <?php echo image_tag( '/uploads/images/AsSeenOn/'.$photo->getFile() ) ?><br />
            <?php echo link_to('&nbsp;&nbsp;&nbsp;Edit Logo', 'photos/asSeenOnLogos?logo_id='.$photo->getId()) ?><br />
            <?php echo link_to('&nbsp;&nbsp;&nbsp;Delete Logo', 'photos/deleteAsSeenOnLogo?id='.$photo->getId(), 'confirm=Are you sure you want to delete this photo?') ?><br />
        </div>
        <?php if( $i++ % 6 == 0 ): ?>
            </fieldset>
            <br />
            <fieldset class="form_fields">
        <?php endif; ?>
    <?php endforeach; ?>
    </fieldset><br />
    
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/asSeenOnLogos')); ?><br />
    
</div>
