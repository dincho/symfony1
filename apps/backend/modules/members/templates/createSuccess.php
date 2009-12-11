<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>
<?php if ( !isset($member) ): ?>
    <?php $member = new Member(); ?>
<?php endif; ?>

<?php echo form_tag('members/create', array('class' => 'form', "id" => "member_registration_form")) ?>
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
        <?php echo pr_select_country_tag('country', $member->getCountry(), array('class' => error_class('country', true), 'include_custom' => 'Please Select')) ?><br />
        
        <div id="adm1_container" style="display: <?php echo ( $has_adm1 ) ? 'block' : 'none';?>">
          <label for="state_id">State / Province</label>
            <?php echo pr_object_select_adm1_tag($member, 'getAdm1Id', array('class' => error_class('adm1_id', true), 'include_custom' => 'Please Select')) ?><br />
        </div>
    
        <div id="adm2_container" style="display: <?php echo ( $has_adm2 ) ? 'block' : 'none';?>">
          <label for="district">District / Borough / County</label>
            <?php echo pr_object_select_adm2_tag($member, 'getAdm2Id', array('class' => error_class('adm2_id', true), 'include_custom' => 'Please Select')) ?><br />
        </div>
        
        <label for="city_id">City</label>
        <?php echo pr_object_select_city_tag($member, 'getCityId', array('class' => error_class('city_id', true),  'include_custom' => 'Please Select')); ?><br /> 
                        
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

<?php include_partial('members/geo_fields_js'); ?>