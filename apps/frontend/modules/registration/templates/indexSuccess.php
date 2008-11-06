<?php use_helper('dtForm', 'Javascript'); ?>

<?php echo __('Please finish your registration') ?><br />
<?php echo __('Please register. Reminder: If you\'re not 19 or older, you are not allowed to be here - you must %link_to_leave_now%', array('%link_to_leave_now%' => link_to(__('leave now!'), 'http://google.com/'))) ?><br />
<span><?php echo __('Note: You will be able to update this information later.') ?></span>
<?php echo form_tag('registration/index', array('id' => 'public_reg_form')) ?>
    <fieldset>
        <?php echo pr_label_for('language', 'Language') ?>
        <?php echo pr_select_language_tag('language', ($member->getLanguage()) ? $member->getLanguage() : 'en') ?><br />
        
        <?php echo pr_label_for('country', 'Country of Residence') ?>
        <?php echo pr_select_country_tag('country', $member->getCountry()) ?><br />
        
        <?php echo pr_label_for('state', 'Area') ?>
        <?php echo pr_select_state_tag($member->getCountry(), 'state', $member->getStateId()) ?><br />
        
        <?php echo pr_label_for('district', 'District/ Borough/ County etc.') ?>
        <?php echo object_input_tag($member, 'getDistrict') ?>
        <span><?php echo __('(optional)') ?></span><br />
        
        <?php echo pr_label_for('city', 'City') ?>
        <?php echo object_input_tag($member, 'getCity') ?><br />
        
        <?php echo pr_label_for('zip', 'Zip Code') ?>
        <?php echo object_input_tag($member, 'getZip') ?><br />
        
        <?php echo pr_label_for('nationality', 'Nationality') ?>
        <?php echo object_input_tag($member, 'getNationality') ?><br />
        
        <?php echo pr_label_for('first_name', 'First Name') ?>
        <?php echo object_input_tag($member, 'getFirstName') ?><br />
        
        <?php echo pr_label_for('last_name', 'Last Name') ?>
        <?php echo object_input_tag($member, 'getLastName') ?>
        <span><?php echo __('(optional)') ?></span><br />
    </fieldset>
    <span class="public_reg_notice"><?php echo __('Important Notice: You are NOT allowed to continue and to use this service, if you have been convicted, or if you are charged with any crime of violence, domestic violence, or if you are married, or if you are a sex offender (registered or not registered). We will take legal action against those who will not comply with these requirements.') ?></span> 
    <fieldset>
        <?php echo submit_tag('', array('class' => 'save_and_cont')) ?>
    </fieldset>
    <span><?php echo __('Note: You will be able to change this information later.') ?></span>
</form>

<?php echo observe_field('country', array(
    'success'  => 'updateStates(request, json)',
    'url'      => 'ajax/getStatesByCountry',
    'with'     => "'country=' + value",
    //'loading'  => visual_effect('appear', 'loader1'),
    //'complete' => visual_effect('fade', 'loader1').
    //              visual_effect('highlight', 'did_id'),    
)) ?>

<?php echo javascript_tag("
function updateStates(request, json)
{
  var nbElementsInResponse = json.length;
  var S = $('state');
  S.options.length = 0;  
  
  for (var i = 0; i < nbElementsInResponse; i++)
  {
     S.options[i] = new Option(json[i].title, json[i].id);
  }
}
") ?>