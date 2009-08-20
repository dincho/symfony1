<?php use_helper('dtForm', 'Javascript', 'Object'); ?>

<?php echo __('Here you may change your registration information.') ?><br />
<span><?php echo __('Make changes and click save.') ?></span><br />
<br style="line-height:10px;" />
<?php echo form_tag('editProfile/registration', array('id' => 'public_reg_form', 'class' => 'member_reg')) ?>
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
        
        <?php echo pr_label_for('email', __('Your email address') . '<span style="color:red;">*</span>') ?>
        <?php echo object_input_tag($member, 'getEmail') ?><br />    
        
        <?php echo pr_label_for('password', __('Create Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('password') ?><br />
        
        <?php echo pr_label_for('repeat_password', __('Repeat Password') . '<span style="color:red;">*</span>') ?>
        <?php echo input_password_tag('repeat_password') ?><br />
        
        <?php echo pr_label_for('looking_for', __('You are') . '<span style="color:red;">*</span>') ?>
        <?php echo select_tag('looking_for', looking_for_options($member->getSex() . '_' . $member->getLookingFor()), array("disabled" => "true")) ?><br />
        
        <?php echo pr_label_for('country', __('Country of Residence') . '<span style="color:red;">*</span>') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry()) ?><br />
        
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
    </fieldset>
    <fieldset>
        <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
    </fieldset>
</form>

<?php include_partial('content/footer_menu') ?>
<?php include_partial('editProfile/geo_fields_js'); ?>


<?php echo javascript_tag("
if (document.getElementsByTagName) 
{ 
    var inputElements = document.getElementsByTagName('input'); 
    for (i=0; inputElements[i]; i++) 
    { 
        if (inputElements[i].id && (inputElements[i].id.indexOf('password') != -1)) 
        { 
            inputElements[i].setAttribute('autocomplete','off'); 
        } 
    } 
}
") ?>