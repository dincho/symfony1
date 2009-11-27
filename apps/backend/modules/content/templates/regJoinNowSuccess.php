<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regJoinNow', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Join Now</div>
    <fieldset class="form_fields float-left">
        <label for="culture">Language</label>
        <var><?php echo  format_language($culture) ?></var><br />
        
        <label for="trans_19">Headline</label>
        <?php echo textarea_tag('trans[19]', (isset($trans[19])) ? $trans[19]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_20">Instruction</label>
        <?php echo textarea_tag('trans[20]', (isset($trans[20])) ? $trans[20]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="trans_30">Username available</label>
        <?php echo textarea_tag('trans[30]', (isset($trans[30])) ? $trans[30]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
    </fieldset>
    
      <fieldset class="form_fields float-left">
        
        <label for="keywords">Keywords:</label>
        <?php echo input_tag('trans[146]', (isset($trans[146])) ? $trans[146]->getTarget() : null) ?><br />
        
        <label for="description">Description:</label>
        <?php echo textarea_tag('trans[147]', (isset($trans[147])) ? $trans[147]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
       
      </fieldset>
          
    <fieldset class="form_fields error_msgs_fields" style="margin-top: 350px;">
        <label>Error Messages</label>
        <?php echo input_tag('trans[21]', (isset($trans[21])) ? $trans[21]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[22]', (isset($trans[22])) ? $trans[22]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[23]', (isset($trans[23])) ? $trans[23]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[24]', (isset($trans[24])) ? $trans[24]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[25]', (isset($trans[25])) ? $trans[25]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[26]', (isset($trans[26])) ? $trans[26]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[27]', (isset($trans[27])) ? $trans[27]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[28]', (isset($trans[28])) ? $trans[28]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[29]', (isset($trans[29])) ? $trans[29]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[31]', (isset($trans[31])) ? $trans[31]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[136]', (isset($trans[136])) ? $trans[136]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/regJoinNow?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/regJoinNow?culture=pl') ?>&nbsp;</li>
  </ul>
</div>