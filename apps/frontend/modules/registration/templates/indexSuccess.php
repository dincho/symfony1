<?php use_helper('dtForm', 'Javascript', 'Object'); ?>

<?php 
	$first_name_options = array("class" => "essay", "size" => 30, "maxlength" => 50);
	$submit_button_options = array("class" => "button");
	$orientation_options = array();

    if( $sf_request->hasParameter('confirm') )
    {
         $first_name_options = array("class" => "essay", "size" => 30, "maxlength" => 50, "style" => "border-color:#F00;", "readonly" => "true");
         $submit_button_options = array("class" => "button_disabled", "disabled" => "true");
         $orientation_options = array("style" => "border-color:#F00;", "disabled" => "true");
    }    
    elseif( $member->getOriginalFirstName() )
    {
         $first_name_options = array("class" => "essay", "size" => 30, "maxlength" => 50, "readonly" => "true");
         $orientation_options = array("disabled" => "true");
    }
?>
       
<?php echo __('Registration instructions') ?>
<?php echo __('Registration note') ?>

<?php echo form_tag('registration/index', array('id' => 'public_reg_form', 'name' => 'public_reg_form')) ?>
    <fieldset>
        
        <?php if( $sf_user->getCulture() == 'pl'): ?>
        <div id="essay_polish_letters">
            <?php echo link_to_function('ą', 'pl_letter_press("ą")') ?>
            <?php echo link_to_function('ć', 'pl_letter_press("ć")') ?>
            <?php echo link_to_function('ę', 'pl_letter_press("ę")') ?>
            <?php echo link_to_function('ł', 'pl_letter_press("ł")') ?>
            <?php echo link_to_function('ń', 'pl_letter_press("ń")') ?>
            <?php echo link_to_function('ó', 'pl_letter_press("ó")') ?>
            <?php echo link_to_function('ś', 'pl_letter_press("ś")') ?>
            <?php echo link_to_function('ż', 'pl_letter_press("ż")') ?>
            <?php echo link_to_function('ź', 'pl_letter_press("ź")') ?>
        </div><br />
        <?php endif; ?>
        
        <?php if( $sf_request->hasParameter('confirm') ): ?>
            <?php echo input_hidden_tag('confirmed', 1)?>
        <?php endif; ?>
        
        <?php echo pr_label_for('country', __('Country of Residence') . '<span style="color:red;">*</span>') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry(), array('include_custom' => __('Please Select'))) ?><br />
        
        <?php echo pr_label_for('adm1_id', __('Area') . '<span style="color:red;">*</span>') ?>
        <?php echo pr_object_select_adm1_tag($member, 'getAdm1Id', array('include_custom' => __('Please Select'))) ?><br />
        
        <?php echo pr_label_for('adm2_id', __('District / Borough')) ?>
        <?php echo pr_object_select_adm2_tag($member, 'getAdm2Id', array('include_custom' => __('Please Select'), 'onchange' => 'clearCity()')) ?><br />
        
        <?php echo pr_label_for('city', __('City') . '<span style="color:red;">*</span>') ?>
        <?php echo input_auto_complete_tag('city', strip_tags($member->getCity(ESC_RAW)),
            'ajax/autocompleteCity',
            array('autocomplete' => 'off'),
            array('use_style'    => true, 
            'frequency' => 0.2,
            'class' => 'essay',
            'size' => 30, 
            'maxlength' => 50,
            'with'  => " value+'&country='+$('country').value+'&adm1_id='+$('adm1_id').value+'&adm2_id='+$('adm2_id').value"
        ));?><br />
        
        <?php echo pr_label_for('zip', __('Zip Code') . '<span style="color:red;">*</span>') ?>
        <?php echo input_tag('zip', strip_tags($member->getZip(ESC_RAW)) ,array('class' => 'essay', 'size' => 30, 'maxlength' => 50)) ?><br />
        
        <?php echo pr_label_for('nationality', __('Nationality') . '<span style="color:red;">*</span>') ?>
        <?php echo input_tag('nationality', strip_tags($member->getNationality(ESC_RAW)), array('class' => 'essay', 'size' => 30, 'maxlength' => 50)) ?><br />
        

        <?php echo pr_label_for('first_name', __('First Name') . '<span style="color:red;">*</span>') ?>
        <?php echo input_tag('first_name', strip_tags($member->getFirstname(ESC_RAW)), $first_name_options) ?><br />
        
        <?php echo pr_label_for('orientation', __('You are') . '<span style="color:red;">*</span>') ?>
        <?php echo select_tag('orientation', looking_for_options($member->getOrientation()), $orientation_options) ?><br />
    </fieldset>
    <?php echo __('Registration notice') ?> 
    <fieldset>
        <?php echo submit_tag(__('Save and Continue'), $submit_button_options) ?>
    </fieldset>
    <?php echo __('Registration note') ?>
</form>

<?php include_partial('editProfile/geo_fields_js'); ?>