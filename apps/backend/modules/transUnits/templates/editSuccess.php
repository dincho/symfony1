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
	    
	    <label for="target">Target:</label>
	    <?php echo object_textarea_tag($trans_unit, 'getTarget', array ('size' => '60x5')) ?><br />
	    
	    <label for="tags">Tags:</label>
	    <?php echo object_textarea_tag($trans_unit, 'getTags', array ('size' => '60x5')) ?><br />
	    
	    <label for="translated">Translated:</label>
	    <?php echo object_checkbox_tag($trans_unit, 'getTranslated', array('class' => 'checkbox'))?><br />
    </fieldset>
    
    <fieldset class="actions">
    <?php echo button_to('Cancel', 'transUnits/list?cancel=1')  . 
               button_to('Delete', 'transUnits/delete?id=' . $trans_unit->getId(), 'confirm=Are you sure you want to delete this unit?') . 
               submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>

