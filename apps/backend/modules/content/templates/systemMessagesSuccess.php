<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/systemMessages', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit System Messages</div>
    <fieldset class="form_fields">
        <label for="culture">Language</label>
        <var><?php echo format_language($culture) ?></var><br /><br />
        
        <label>Complete registration</label><?php echo input_tag('trans[89]', (isset($trans[89])) ? $trans[89]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[90]', (isset($trans[90])) ? $trans[90]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Delete Your Account</label><?php echo input_tag('trans[91]', (isset($trans[91])) ? $trans[91]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[92]', (isset($trans[92])) ? $trans[92]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Email verification</label><?php echo input_tag('trans[93]', (isset($trans[93])) ? $trans[93]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[94]', (isset($trans[94])) ? $trans[94]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>New password confirmation</label><?php echo input_tag('trans[95]', (isset($trans[95])) ? $trans[95]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[96]', (isset($trans[96])) ? $trans[96]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Forgot password confirmation</label><?php echo input_tag('trans[143]', (isset($trans[143])) ? $trans[143]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[144]', (isset($trans[144])) ? $trans[144]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Status canceled</label><?php echo input_tag('trans[97]', (isset($trans[97])) ? $trans[97]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[98]', (isset($trans[98])) ? $trans[98]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Status denied</label><?php echo input_tag('trans[99]', (isset($trans[99])) ? $trans[99]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[100]', (isset($trans[100])) ? $trans[100]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Status flagged</label><?php echo input_tag('trans[101]', (isset($trans[101])) ? $trans[101]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[102]', (isset($trans[102])) ? $trans[102]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Status pending</label><?php echo input_tag('trans[103]', (isset($trans[103])) ? $trans[103]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[104]', (isset($trans[104])) ? $trans[104]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Status suspended</label><?php echo input_tag('trans[105]', (isset($trans[105])) ? $trans[105]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[106]', (isset($trans[106])) ? $trans[106]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Tell a friend</label><?php echo input_tag('trans[107]', (isset($trans[107])) ? $trans[107]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[108]', (isset($trans[108])) ? $trans[108]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Email undo</label><?php echo input_tag('trans[109]', (isset($trans[109])) ? $trans[109]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[110]', (isset($trans[110])) ? $trans[110]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Verify email</label><?php echo input_tag('trans[111]', (isset($trans[111])) ? $trans[111]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[112]', (isset($trans[112])) ? $trans[112]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
        <label>Welcome</label><?php echo input_tag('trans[113]', (isset($trans[113])) ? $trans[113]->getTarget() : null) ?><br />
        <label></label><?php echo textarea_tag('trans[114]', (isset($trans[114])) ? $trans[114]->getTarget() : null, array('cols' => 40, 'rows' => 3)) ?><br />
        
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/systemMessages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/systemMessages?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/systemMessages?culture=pl') ?>&nbsp;</li>
  </ul>
</div>