<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/editEssay', 'class=form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Essay</div>
  <fieldset class="form_fields">
    <label for="essay_headline">Headline</label>
    <?php echo object_input_tag($member, 'getEssayHeadline') ?><br />
    
    <label for="essay_introduction">Introduction</label>
    <?php echo object_textarea_tag($member, 'getEssayIntroduction', array('rows' => 10, 'cols' => 80)) ?><br />
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editEssay?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>