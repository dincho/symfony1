<?php use_helper('dtForm', 'Javascript'); ?>

<?php slot('header_title') ?>
    <?php echo __('Registration headline') ?>
<?php end_slot(); ?>

<?php 
	$first_name_options = array();
	$submit_button_options = array("class" => "button");
	$orientation_options = array();

    if( $sf_request->hasParameter('confirm') )
    {
         $first_name_options = array("style" => "border-color:#F00;", "readonly" => "true");
         $submit_button_options = array("class" => "button_disabled", "disabled" => "true");
         $orientation_options = array("style" => "border-color:#F00;", "disabled" => "true");
    }    
    elseif( $member->getOriginalFirstName() )
    {
         $first_name_options = array("readonly" => "true");
         $orientation_options = array("disabled" => "true");
    }
?>
       
<?php echo __('Registration instructions') ?>
<?php echo __('Registration note') ?>

<?php echo form_tag('registration/index', array('id' => 'public_reg_form', 'name' => 'public_reg_form')) ?>
    <fieldset>
        <?php if( $sf_request->hasParameter('confirm') ): ?>
            <?php echo input_hidden_tag('confirmed', 1)?>
        <?php endif; ?>
        
        <?php echo pr_label_for('country', __('Country of Residence') . '<span style="color:red;">(*)</span>') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry(), array('include_custom' => __('Please Select'))) ?><br />
        
        <?php echo pr_label_for('adm1_id', __('Area')) ?>
        <?php echo pr_object_select_adm1_tag($member, 'getAdm1Id', array('include_custom' => __('Please Select'))) ?><br />
        
        <?php echo pr_label_for('adm2_id', __('District / Borough / County')) ?>
        <?php echo pr_object_select_adm2_tag($member, 'getAdm2Id', array('include_custom' => __('Please Select'), 'onchange' => 'clearCity()')) ?><br />
        
        <?php echo pr_label_for('city', __('City') . '<span style="color:red;">(*)</span>') ?>
        <?php echo input_auto_complete_tag('city', $member->getCity(),
            'ajax/AutocompleteCity',
            array('autocomplete' => 'off'),
            array('use_style'    => true, 
            'frequency' => 0.2,
            'with'  => " value+'&country='+$('country').value+'&adm1_id='+$('adm1_id').value+'&adm2_id='+$('adm2_id').value"
        ));?><br />
        
        <?php echo pr_label_for('zip', __('Zip Code') . '<span style="color:red;">(*)</span>') ?>
        <?php echo object_input_tag($member, 'getZip') ?><br />
        
        <?php echo pr_label_for('nationality', __('Nationality') . '<span style="color:red;">(*)</span>') ?>
        <?php echo object_input_tag($member, 'getNationality') ?><br />
        

        <?php echo pr_label_for('first_name', __('First Name') . '<span style="color:red;">(*)</span>') ?>
        <?php echo object_input_tag($member, 'getFirstName', $first_name_options) ?><br />
        
        <?php echo pr_label_for('orientation', __('You are')) ?>
        <?php echo select_tag('orientation', looking_for_options($member->getOrientation()), $orientation_options) ?><br />
    </fieldset>
    <?php echo __('Registration notice') ?> 
    <fieldset>
        <?php echo submit_tag(__('Save and Continue'), $submit_button_options) ?>
    </fieldset>
    <?php echo __('Registration note') ?>
</form>

<?php include_partial('editProfile/geo_fields_js'); ?>