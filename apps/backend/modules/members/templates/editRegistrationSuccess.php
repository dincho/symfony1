<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Registration</div>

<?php echo form_tag('members/editRegistration', 'class=form id=member_registration_form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editRegistration?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
    
  <fieldset class="form_fields">
  
    <?php echo pr_label_for('password', 'Change Password', array('id' => 'labels_160')) ?>
    <?php echo input_password_tag('password') ?><br />
    
    <?php echo pr_label_for('repeat_password', 'Repeat Password', array('id' => 'labels_160')) ?>
    <?php echo input_password_tag('repeat_password') ?><br />
    
    <label for="catalog">Catalog</label>
    <?php echo object_select_tag($member, 'getCatalogId', array('related_class' => 'Catalogue')) ?><br />
        
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
    <?php echo object_input_tag($member, 'getZip', error_class('zip')) ?><br />
    
    <label for="nationality">Nationality</label>
    <?php echo object_input_tag($member, 'getNationality', error_class('nationality')) ?><br />
    
    <label for="timezone">Timezone</label>
    <var><?php echo $member->getTimezone(); ?></var><br />
        
  </fieldset> 
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editRegistration?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>
<?php include_partial('members/geo_fields_js'); ?>