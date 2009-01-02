<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/regSelf', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Self-Description</div>
    <fieldset class="form_fields">
        <label for="culture">Language</label>
        <var><?php echo format_language($culture) ?></var><br />
        
        <label for="trans_40">Headline</label>
        <?php echo textarea_tag('trans[40]', (isset($trans[40])) ? $trans[40]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_41">Instruction</label>
        <?php echo textarea_tag('trans[41]', (isset($trans[41])) ? $trans[41]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="trans_42">Reminder</label>
        <?php echo textarea_tag('trans[42]', (isset($trans[42])) ? $trans[42]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label for="trans_43">Note</label>
        <?php echo textarea_tag('trans[43]', (isset($trans[43])) ? $trans[43]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[44]', (isset($trans[44])) ? $trans[44]->getTarget() : null) ?><br />
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/regpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/regSelf?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/regSelf?culture=pl') ?>&nbsp;</li>
  </ul>
</div>