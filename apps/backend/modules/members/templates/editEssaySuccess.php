<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Essay</div>
  
<?php echo form_tag('members/editEssay', array('class' => 'form', 'onsubmit' => 'return check_essay_fields("Some of the essay fields are empty, are you sure you want to save it anyway?");')) ?>

  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editEssay?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
    
  <fieldset class="form_fields">
    <label for="essay_headline">Headline</label>
    <?php echo object_input_tag($member, 'getEssayHeadline') ?><br />
    
    <label for="essay_introduction">Introduction</label>
    <?php echo object_textarea_tag($member, 'getEssayIntroduction', array('rows' => 10, 'cols' => 80)) ?><br />  
  </fieldset> 
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editEssay?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php echo javascript_tag('

    function check_essay_fields(confirm_msg)
    {
      if( document.getElementById("essay_headline").value.length < 1 || document.getElementById("essay_introduction").value.length < 1 ) 
      {
        return confirm(confirm_msg);
      }

  
      return true;
    }
'); ?>
<?php include_partial('members/subMenu', array('member' => $member)); ?>