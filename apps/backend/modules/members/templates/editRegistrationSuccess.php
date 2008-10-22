<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/editRegistration', 'class=form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Registration</div>
  <fieldset class="form_fields">
    
    <label for="country">Country of Residence</label>
    <?php echo object_select_country_tag($member, 'getCountry', error_class('first_name')) ?><br />
    
    <label for="state_id">State / Province</label>
    <?php echo select_tag('state_id', objects_for_select($states, 'getId', 'getTitle', $member->getStateId(), 'include_blank=true'), error_class('state_id')) ?><br />

    <label for="district">District / Borough / County</label>
    <?php echo object_input_tag($member, 'getDistrict', error_class('district')) ?><br />
          
    <label for="city">City</label>
    <?php echo object_input_tag($member, 'getCity', error_class('city')) ?><br />
    
    <label for="zip">Zip Code</label>
    <?php echo object_input_tag($member, 'getZip', error_class('zip')) ?><br />
    
    <label for="nationality">Nationality</label>
    <?php echo object_input_tag($member, 'getNationality', error_class('nationality')) ?><br />
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editRegistration?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>

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
  var S = $('state_id');
  S.options.length = 0;  
  
  for (var i = 0; i < nbElementsInResponse; i++)
  {
     S.options[i] = new Option(json[i].title, json[i].id);
  }
}
") ?>