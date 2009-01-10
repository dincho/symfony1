<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/create', array('class' => 'form')) ?>
    <div class="legend">Create member</div>
    <fieldset class="form_fields">
         
        <label for="language">Native Language</label>
        <?php echo pr_select_language_tag('language', null, array('class' => error_class('language', true))) ?><br />
            
        <label for="email">Your email</label>
        <?php echo input_tag('email', null, error_class('email')) ?><br />

        <label for="password">Create Password</label>
        <?php echo input_password_tag('password', null, error_class('password')) ?><br />
        
        <label for="repeat_password">Repeat Password</label>
        <?php echo input_password_tag('repeat_password', null, error_class('repeat_password')) ?><br />
        
        <label for="looking_for">You are</label>
        <?php echo select_tag('looking_for', looking_for_options()) ?><br />
                
        <label for="country">Country of Residence</label>
        <?php echo select_country_tag('country', 'US', array('class' => error_class('country', true))) ?><br />
        
        <label for="state_id">State / Province</label>
        <?php echo pr_select_state_tag( ($sf_request->hasParameter('country') )? $sf_request->getParameter('country') : 'US', 'state_id', null, array('class' => error_class('state_id', true))) ?><br />
        
        <label for="district">District / Borough / County</label>
        <?php echo input_tag('district', null, error_class('district')) ?><br />
              
        <label for="city">City</label>
        <?php echo input_tag('city', null, error_class('city')) ?><br />
        
        <label for="zip">Zip Code</label>
        <?php echo input_tag('zip', null, error_class('zip')) ?><br />
        
        <label for="nationality">Nationality</label>
        <?php echo input_tag('nationality', null, error_class('nationality')) ?><br />
            
        <label for="first_name">First Name</label>
        <?php echo input_tag('first_name', null, error_class('first_name')) ?><br />
        
        <label for="last_name">Last Name</label>
        <?php echo input_tag('last_name', null, error_class('last_name')) ?><br />
        
        <label for="username">Username</label>
        <?php echo input_tag('username', null, error_class('username')) ?><br />
    </fieldset>
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'members/list')  . submit_tag('Save', 'class=button') ?>
    </fieldset>    
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