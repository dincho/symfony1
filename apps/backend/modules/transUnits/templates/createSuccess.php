<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('transUnits/create', 'class=form') ?>
    <div class="legend">Creating Translation Unit</div>
    <fieldset class="form_fields">
        <div style="float:left;">
            <label for="source">Source:</label>
            <?php echo textarea_tag('source', null, array('size' => '60x5')) ?><br/>
    
            <label for="tags">Tags:</label>
            <?php echo textarea_tag('tags', null, array('size' => '60x5')) ?><br/>
            
            <label for="link">Link:</label>
            <?php echo input_tag('link', null, array('style' => 'width: 384px')) ?>
        </div>
        <?php echo select_tag( 'defined_tags', options_for_select(TransUnitPeer::getTagsWithKeys(), null),
                                            array(
                                                'multiple' => true,
                                                'style' => 'width:250px; height:327px;',
                                                'onclick' => 'add_tags(this.value, "tags")'
                                            )
        )?>
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'transUnits/list?cancel=1') . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

