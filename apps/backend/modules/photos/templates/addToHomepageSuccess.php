<?php use_helper('I18N') ?>
<?php echo image_tag( $photo->getImageUrlPath('file', '100x95'), array('class' => 'float-left') ) ?>
<br /><br /><br /><br /><br />

<?php echo form_tag('photos/addToHomepage') ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    
    <div class="form_fields float-left">
        <label style="width: 140px">Homepage set</label>
        <?php echo select_tag('homepages_set', options_for_select(array(1 => 'S1', 2 => 'S2', 3 => 'S3'), $homepages_set, 'include_blank=true'), array('class' => 'limit_input')) ?><br />
        <label style="width: 140px">Homepage position</label>
        <?php echo select_tag('homepages_pos', options_for_select(array(1 => 'A1', 2 => 'B1', 3 => 'C1', 4 => 'A2', 5 => 'B2', 6 => 'C2', 7 => 'A3', 8 => 'B3', 9 => 'C3'), $homepages_pos, 'include_blank=true'), array('class' => 'limit_input')) ?><br />
    </div><br /><br /><br />
    
    
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