<?php use_helper('I18N') ?>
<?php echo image_tag( $photo->getImageUrlPath('file', '100x95'), array('class' => 'float-left') ) ?>
<br /><br /><br /><br /><br /><br /><br />

<?php echo form_tag('photos/addToJoinNow') ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
   <!-- <fieldset class="form_fields">
        <label style="width: auto">Language</label>
        <?php //echo select_language_tag('catalog', $catalog, array('languages' => array('en', 'pl'))) ?><br />
    </fieldset>
   -->

    <table class="zebra" style="width: 300px">
        <tr>
            <th colspan="2">Languages</th>
        </tr>
        <?php foreach($catalogs as $catalog): ?>
            <tr>
                <td style="width:5px; padding: 0;"><?php echo checkbox_tag('catalogs[]', $catalog->getCatId(), in_array($catalog->getCatId(), $joinNow)) ?></td>
                <td><?php echo $catalog; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'photos/stockPhotos') ?>
        <?php echo submit_tag('Next') ?>
    </fieldset>
</form>
