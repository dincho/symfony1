<?php use_helper('dtForm', 'Javascript', 'Object'); ?>

<?php echo __('Here you may change your registration information.') ?><br />
<span><?php echo __('Make changes and click save.') ?></span><br />
<br style="line-height:10px;" />
<?php echo form_tag('editProfile/registration', array('id' => 'public_reg_form', 'class' => 'member_reg')) ?>
    <fieldset>
        <?php echo pr_label_for('email', __('Your email address')) ?>
        <?php echo object_input_tag($member, 'getEmail') ?><br />    
        
        <?php echo pr_label_for('password', __('Create Password')) ?>
        <?php echo input_password_tag('password') ?><br />
        
        <?php echo pr_label_for('repeat_password', __('Repeat Password')) ?>
        <?php echo input_password_tag('repeat_password') ?><br />
        
        <?php echo pr_label_for('looking_for', __('You are')) ?>
        <?php echo select_tag('looking_for', looking_for_options($member->getSex() . '_' . $member->getLookingFor()), array("disabled" => "true")) ?><br />
        
        <?php echo pr_label_for('country', __('Country of Residence')) ?>
        <?php echo pr_select_country_tag('country', $member->getCountry()) ?><br />
        
        <?php echo pr_label_for('state_id', __('Area')) ?>
        <?php echo pr_object_select_state_tag($member, 'getStateId') ?><br />
        
        <?php echo pr_label_for('city', __('City')) ?>
        <?php echo object_input_tag($member, 'getCity') ?><br />
        
        <?php echo pr_label_for('zip', __('Zip Code')) ?>
        <?php echo object_input_tag($member, 'getZip') ?><br />
        
        <?php echo pr_label_for('nationality', __('Nationality')) ?>
        <?php echo object_input_tag($member, 'getNationality') ?><br />
    </fieldset>
    <fieldset>
        <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
    </fieldset>
</form>

<?php include_partial('content/footer_menu') ?>

<?php echo observe_field('country', array(
    'success'  => 'updateStates(request, json)',
    'url'      => 'ajax/getStatesByCountry',
    'with'     => "'country=' + value",
)) ?>

<?php echo javascript_tag("
function updateStates(request, json)
{
  var nbElementsInResponse = json.length;
  var S = $('state_id');
  S.options.length = 0;  
  
  for (var i = 0; i < nbElementsInResponse; i++)
  {
     S.options[i] = new Option(json[i].title, json[i].id);
  }
}
") ?>
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