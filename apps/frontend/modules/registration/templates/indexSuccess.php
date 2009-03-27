<?php use_helper('dtForm', 'Javascript'); ?>

<?php slot('header_title') ?>
    <?php echo __('Registration headline') ?>
<?php end_slot(); ?>

<?php echo __('Registration instructions') ?>
<?php echo __('Registration note') ?>

<?php echo form_tag('registration/index', array('id' => 'public_reg_form', 'name' => 'public_reg_form')) ?>
    <fieldset>
        <?php echo pr_label_for('country', 'Country of Residence') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry(), array('include_custom' => 'Select Country')) ?><br />
        
        <?php echo pr_label_for('state_id', 'Area') ?>
        <?php echo pr_object_select_state_tag($member, 'getStateId') ?><br />
        
        <?php echo pr_label_for('city', 'City') ?>
        <?php echo object_input_tag($member, 'getCity') ?><br />
        
        <?php echo pr_label_for('zip', 'Zip Code') ?>
        <?php echo object_input_tag($member, 'getZip') ?><br />
        
        <?php echo pr_label_for('nationality', 'Nationality') ?>
        <?php echo object_input_tag($member, 'getNationality') ?><br />
        
        <?php if((isset($conf)&&$conf==1)): ?>
            <?php $arr = array("style" => "border-color:#F00;", "readonly" => "true") ?>
            <?php $arr2 = array("class" => "button", "disabled" => "true"); ?>
            <?php $arr3 = array("style" => "border-color:#F00;", "disabled" => "true") ?>
        <?php elseif($member->getFirstName()!=NUll&&$member->getFirstName()!=""): ?>
            <?php $arr = array("readonly" => "true") ?>
            <?php $arr2 = array("class" => "button"); ?>
            <?php $arr3 = array("disabled" => "false") ?>
        <?php else: ?>
            <?php $arr = array("style" => ""); ?>
            <?php $arr2 = array("class" => "button"); ?>
            <?php $arr3 = array("style" => "") ?>
        <?php endif; ?>
        <?php echo pr_label_for('first_name', 'First Name') ?>
        <?php echo object_input_tag($member, 'getFirstName', $arr) ?><br />
        
        <?php echo pr_label_for('orientation', __('You are')) ?>
        <?php echo select_tag('orientation', looking_for_options_admin($member->getSex(), $member->getLookingFor()), $arr3) ?><br />
        <?php if(isset($youare)): ?>
            <?php echo input_tag('orientation_hidden', $youare, array("style" => "display:none;")) ?>
        <?php endif; ?>
    </fieldset>
    <?php echo __('Registration notice') ?> 
    <fieldset>
        <?php echo submit_tag(__('Save and Continue'), $arr2) ?>
    </fieldset>
    <?php echo __('Registration note') ?>
</form>

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