<?php use_helper('dtForm', 'Javascript'); ?>

<?php $member = $sf_data->getRaw('member'); //it's not secutiry flaw since this page is only accessible by the member itself. ?>

<?php 
    $submit_button_options = array("class" => "button");
    $orientation_options = array();

    if( $sf_request->hasParameter('confirm') )
    {
         $submit_button_options = array("class" => "button_disabled", "disabled" => "true");
         $orientation_options = array("style" => "border-color:#F00;", "disabled" => "true");
    }    
    elseif( !is_null($member->getOriginalFirstName()) )
    {
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
        
        <?php echo pr_label_for('country', __('Country of Residence') . '<span style="color:red;">*</span>') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry(), array('include_custom' => __('Please Select'))) ?><br />
        
        
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