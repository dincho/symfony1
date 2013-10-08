<?php use_helper('Object', 'dtForm', 'I18N', 'Catalog') ?>
<?php include_component('system', 'formErrors') ?>

<?php if( $pager->hasResults() ): ?>
    <div id="profile_pager">
        <?php echo link_to_unless(is_null($pager->getPrevious()), '&lt;&lt;&nbsp;Previous', 'transUnits/edit?id=' . $pager->getPrevious(), array()) ?>
        <?php echo link_to("Back to List", 'transUnits/list', array('class' => 'sec_link')) ?>
        <?php echo link_to_unless(is_null($pager->getNext()), 'Next&nbsp;&gt;&gt;', 'transUnits/edit?id=' . $pager->getNext(), array()) ?>
    </div>
    <br />
<?php endif; ?>


<?php echo form_tag('transUnits/edit', 'class=form') ?>
    <?php echo object_input_hidden_tag($trans_unit, 'getId', 'class=hidden') ?>
    <div class="legend">Edit Translation Unit</div>
    <fieldset class="form_fields">
        <label for="catalogue">Catalogue:</label>
        <?php echo select_catalog2url(
            null,
            'transUnits/editRelated?id=' . $trans_unit->getId(),
            $trans_unit->getCatId()
        ); ?><br/>
        <div style="float:left;">
            <label for="source">Source:</label>
            <?php echo object_textarea_tag($trans_unit, 'getSource', array('size' => '60x5')) ?><br/>
        
            <?php if ($trans_unit->getCatalogue()->getTargetLang() != 'en' && $en_trans_unit): ?>
                <label for="en_target">English Target:</label>
                <?php echo object_textarea_tag(
                    $en_trans_unit,
                    'getTarget',
                    array('size' => '60x5', 'control_name' => 'en_target')
                ) ?><br/>
            <?php endif; ?>
    
            <label for="target">Target:</label>
            <?php echo object_textarea_tag($trans_unit, 'getTarget', array('size' => '60x5')) ?><br/>
    
            <label for="tags">Tags:</label>
            <?php echo object_textarea_tag($trans_unit, 'getTags', array('size' => '60x5')) ?><br/>
            
            <label for="link">Link:</label>
            <?php echo object_input_tag($trans_unit, 'getLink', array('style' => 'width: 350px')) ?>
            <?php if ($trans_unit->getLink()) {
                echo link_to('Open', $trans_unit->getLink(), array('popup' => true, 'class' => 'float-left'));
            } ?>
            <br/>
    
            <label for="translated">Translated:</label>
            <?php echo object_checkbox_tag($trans_unit, 'getTranslated', array('class' => 'checkbox')) ?>
        </div>
        <div style="float:left;">
            <?php echo select_tag( 'defined_tags', options_for_select(TransUnitPeer::getTagsWithKeys(), null),
                                                    array(
                                                        'multiple' => true,
                                                        'style' => 'width:250px; height:327px;',
                                                        'onclick' => 'add_tags(this.value, "tags")'
                                                    )
            )?>
        </div>
    </fieldset>
    
    <fieldset class="actions">
        <?php $cancel_param = (strpos($sf_user->getRefererUrl(), "?")) ? '&cancel=1' : '?cancel=1'; ?>
        <?php echo button_to('Cancel', $sf_user->getRefererUrl() . $cancel_param) .
            button_to(
                'Delete',
                'transUnits/delete?id=' . $trans_unit->getId(),
                'confirm=Are you sure you want to delete this unit? All other units with this source will be also deleted!'
            ) .
            submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

