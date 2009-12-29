<?php use_helper('dtForm', 'Javascript', 'Object'); ?>
<?php $member = $sf_data->getRaw('member'); //it's not secutiry flaw since this page is only accessible by the member itself. ?>

<?php echo __('Here you may change your registration information.') ?><br />
<span><?php echo __('Make changes and click save.') ?></span><br />
<br style="line-height:10px;" />
<?php echo form_tag('editProfile/registration', array('id' => 'public_reg_form', 'class' => 'member_reg')) ?>
    <fieldset>
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
        
        <div id="adm1_container" style="display: <?php echo ( $has_adm1 ) ? 'block' : 'none';?>">
          <?php echo pr_label_for('adm1_id', __('Area') . '<span style="color:red;">*</span>') ?>
          <?php echo pr_object_select_adm1_tag($member, 'getAdm1Id', array('include_custom' => __('Please Select'))) ?><br />
        </div>
        
        <div id="adm2_container" style="display: <?php echo ( $has_adm2 ) ? 'block' : 'none';?>">
          <?php echo pr_label_for('adm2_id', __('District / Borough') . '<span style="color:red;">*</span>') ?>
          <?php echo pr_object_select_adm2_tag($member, 'getAdm2Id', array('include_custom' => __('Please Select'))) ?><br />
        </div>
        
        <?php echo pr_label_for('city_id', __('City') . '<span style="color:red;">*</span>') ?>
        <?php echo pr_object_select_city_tag($member, 'getCityId', array('include_custom' => __('Please Select'))); ?><br />
        
        <?php echo pr_label_for('nationality', __('Nationality') . '<span style="color:red;">*</span>') ?>
        <?php echo object_input_tag($member, 'getNationality') ?><br />
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