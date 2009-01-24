<?php use_helper('I18N') ?>
<?php echo form_tag('photos/addToHomepage') ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    <?php echo image_tag( $photo->getImageUrlPath('file', '100x96'), array('class' => '') ) ?><br /><br />
    <table class="zebra" style="width: 200px">
        <tr>
            <th colspan="2">Languages</th>
        </tr>
        <?php foreach($catalogs as $catalog): ?>
            <tr>
                <td style="width:5px; padding: 0;"><?php echo checkbox_tag('catalogs[]', $catalog->getTargetLang(), in_array($catalog->getTargetLang(), $homepages)) ?></td>
                <td><?php echo format_language($catalog->getTargetLang()) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'photos/stockPhotos') ?>
        <?php echo submit_tag('Next') ?>
    </fieldset>
</form>