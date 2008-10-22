<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($user, 'getId', 'class=hidden') ?>
  <div class="legend">Editing Member: <?php echo $user->getUsername() ?></div>
  <fieldset class="form_fields">
    
    <label for="first_name">First Name:</label>
    <?php echo object_input_tag($user, 'getFirstName', error_class('first_name')) ?><br />
    
    <label for="last_name">Last Name:</label>
    <?php echo object_input_tag($user, 'getLastName', error_class('last_name')) ?><br />

    <label for="email">Email:</label>
    <?php echo object_input_tag($user, 'getEmail', error_class('email')) ?><br />
          
    <label for="phone">Phone:</label>
    <?php echo object_input_tag($user, 'getPhone', error_class('phone')) ?><br />
              
    <label for="password">Password:</label>
    <?php echo input_password_tag('getPassword', null, error_class('password')) ?><br />
    
    <label for="password2">Re-enter Password:</label>
    <?php echo input_password_tag('password2', null, error_class('password2')) ?><br />
        
    <label for="is_enabled">Status:</label>
    <?php echo select_tag('is_enabled', options_for_select(array(1 => 'Enabled', 0 => 'Disabled'), (int) $user->getIsEnabled())) ?><br />
    
    <label for="user_groups">User Groups:</label>
    <?php echo select_tag('user_groups',
                        objects_for_select($groups, "getId", "getGroupName", $user_groups),
                        array("multiple" => true, "style" => "height: 150px;")
                       )?><br />
                       
    <label for="must_change_pwd">&nbsp;</label>
    <?php echo object_checkbox_tag($user, 'getMustChangePwd', 'class=checkbox') ?><var>User must reset password on next log in.</var><br />
                           
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'users/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>


<?php use_helper('Object') ?>

<?php echo form_tag('members/update') ?>

<?php echo object_input_hidden_tag($member, 'getId') ?>

<table>
<tbody>
<tr>
  <th>Member status:</th>
  <td><?php echo object_select_tag($member, 'getMemberStatusId', array ('related_class' => 'MemberStatus','include_blank' => true,)) ?></td>
</tr>
<tr>
  <th>Username*:</th>
  <td><?php echo object_input_tag($member, 'getUsername') ?></td>
</tr>
<tr>
  <th>Password*:</th>
  <td><?php echo object_input_tag($member, 'getPassword') ?></td>
</tr>
<tr>
  <th>First name*:</th>
  <td><?php echo object_input_tag($member, 'getFirstName') ?></td>
</tr>
<tr>
  <th>Last name*:</th>
  <td><?php echo object_input_tag($member, 'getLastName') ?></td>
</tr>
<tr>
  <th>Email*:</th>
  <td><?php echo object_input_tag($member, 'getEmail') ?></td>
</tr>
<tr>
  <th>Sex*:</th>
  <td><?php echo object_input_tag($member, 'getSex') ?></td>
</tr>
<tr>
  <th>Reviewed by:</th>
  <td><?php echo object_select_tag($member, 'getReviewedBy', array (  'related_class' => 'User',  'include_blank' => true,)) ?></td>
</tr>
<tr>
  <th>Reviewed at:</th>
  <td><?php echo object_input_date_tag($member, 'getReviewedAt', array (  'rich' => true,  'withtime' => true,)) ?></td>
</tr>
<tr>
  <th>Is stared*:</th>
  <td><?php echo object_checkbox_tag($member, 'getIsStared') ?></td>
</tr>
<tr>
  <th>Current flags*:</th>
  <td><?php echo object_input_tag($member, 'getCurrentFlags') ?></td>
</tr>
<tr>
  <th>Total flags*:</th>
  <td><?php echo object_input_tag($member, 'getTotalFlags') ?></td>
</tr>
<tr>
  <th>Unsuspended*:</th>
  <td><?php echo object_input_tag($member, 'getUnsuspended') ?></td>
</tr>
<tr>
  <th>Country*:</th>
  <td><?php echo object_input_tag($member, 'getCountry') ?></td>
</tr>
<tr>
  <th>State:</th>
  <td><?php echo object_input_tag($member, 'getState') ?></td>
</tr>
<tr>
  <th>District*:</th>
  <td><?php echo object_input_tag($member, 'getDistrict') ?></td>
</tr>
<tr>
  <th>City*:</th>
  <td><?php echo object_input_tag($member, 'getCity') ?></td>
</tr>
<tr>
  <th>Zip*:</th>
  <td><?php echo object_input_tag($member, 'getZip') ?></td>
</tr>
<tr>
  <th>Language*:</th>
  <td><?php echo object_input_tag($member, 'getLanguage') ?></td>
</tr>
<tr>
  <th>Birthday:</th>
  <td><?php echo object_input_tag($member, 'getBirthday') ?></td>
</tr>
<tr>
  <th>Display zodiac sign*:</th>
  <td><?php echo object_checkbox_tag($member, 'getDisplayZodiacSign') ?></td>
</tr>
<tr>
  <th>Marital status*:</th>
  <td><?php echo object_select_tag($member, 'getMaritalStatusId', array (  'related_class' => 'MaritalStatus',)) ?></td>
</tr>
<tr>
  <th>Children*:</th>
  <td><?php echo object_select_tag($member, 'getChildrenId', array (  'related_class' => 'Children')) ?></td>
</tr>
<tr>
  <th>Living situation*:</th>
  <td><?php echo object_select_tag($member, 'getLivingSituationId', array (  'related_class' => 'LivingSituation',)) ?></td>
</tr>
<tr>
  <th>Children in future*:</th>
  <td><?php echo object_select_tag($member, 'getChildrenInFutureId', array (  'related_class' => 'ChildrenInFuture',)) ?></td>
</tr>
<tr>
  <th>Essay headline:</th>
  <td><?php echo object_input_tag($member, 'getEssayHeadline') ?></td>
</tr>
<tr>
  <th>Essay introduction:</th>
  <td><?php echo object_textarea_tag($member, 'getEssayIntroduction') ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($member->getId()): ?>
  &nbsp;<?php echo link_to('delete', 'members/delete?id='.$member->getId(), 'post=true&confirm=Are you sure?') ?>
  &nbsp;<?php echo link_to('cancel', 'members/show?id='.$member->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'members/list') ?>
<?php endif; ?>
</form>
