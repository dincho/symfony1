<?php use_helper('Object', 'dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('transUnits/edit', 'class=form') ?>
    <?php echo object_input_hidden_tag($trans_unit, 'getId', 'class=hidden') ?>
    <div class="legend">Edit Translation Unit</div>
    <fieldset class="form_fields">
    
	    <label for="language">Language:</label>
	    <var><?php echo format_language($trans_unit->getCatalogue()->getTargetLang()) ?></var><br />
	    
	    <label for="source">Source:</label>
	    <?php echo object_textarea_tag($trans_unit, 'getSource', array ('size' => '60x5')) ?><br />
	    
	    <?php  if( $trans_unit->getCatId() != 1): ?>
		    <label for="en_target">English Target:</label>
		    <?php echo object_textarea_tag($en_trans_unit, 'getTarget', array ('size' => '60x5', 'control_name' => 'en_target')) ?><br />
	    <?php endif; ?>
	    
	    <label for="target">Target:</label>
	    <?php echo object_textarea_tag($trans_unit, 'getTarget', array ('size' => '60x5')) ?><br />
	    
	    <label for="tags">Tags:</label>
	    <?php echo object_textarea_tag($trans_unit, 'getTags', array ('size' => '60x5')) ?>
	    <?php echo select_tag('defined_tags', 
	                           options_for_select(TransUnitPeer::getTagsWithKeys(), null), 
	                           array('multiple' => true, 'style' => 'width:250px; height:97px', 'onclick' => 'add_tags(this.value, "tags")'))?>
	    <br />
	    
	    <label for="link">Link:</label>
	    <?php echo object_input_tag($trans_unit, 'getLink', array('style' => 'width: 420px')) ?>
	    <?php if( $trans_unit->getLink() ) echo link_to('Open', $trans_unit->getLink(), array('popup' => true, 'class' => 'float-left'))?>
	    <br />
	    
	    <label for="translated">Translated:</label>
	    <?php echo object_checkbox_tag($trans_unit, 'getTranslated', array('class' => 'checkbox'))?><br />
    </fieldset>
    
    <fieldset class="actions">
    <?php echo button_to('Cancel', 'transUnits/list?cancel=1')  . 
               button_to('Delete', 'transUnits/delete?id=' . $trans_unit->getId(), 'confirm=Are you sure you want to delete this unit? All other units with this source will be also deleted!') . 
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

