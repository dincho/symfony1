<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/profilepage', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Profile Page</div>
    <fieldset class="form_fields">
        <div class="float-right">
            <label for="profile_max_photos">Display Photos</label>
            <?php echo input_tag('profile_max_photos', sfConfig::get('app_settings_profile_max_photos'), array('class' => 'mini')) ?><br />
            
            <label for="profile_num_recent_messages">Display Recent Messages</label>
            <?php echo input_tag('profile_num_recent_messages', sfConfig::get('app_settings_profile_num_recent_messages'), array('class' => 'mini')) ?><br /> 
              
            <label for="profile_display_video">Display Video</label>
            <?php echo bool_select_tag('profile_display_video', array(), sfConfig::get('app_settings_profile_display_video')) ?><br />   
        </div>
        <label for="trans_8">Message Panel<br />Signup Preview</label>
        <?php echo textarea_tag('trans[8]', (isset($trans[8])) ? $trans[8]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="trans_9">Message Panel<br />Full View from dashboard</label>
        <?php echo textarea_tag('trans[9]', (isset($trans[9])) ? $trans[9]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php echo input_tag('trans[10]', (isset($trans[10])) ? $trans[10]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[77]', (isset($trans[77])) ? $trans[77]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[78]', (isset($trans[78])) ? $trans[78]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[79]', (isset($trans[79])) ? $trans[79]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[80]', (isset($trans[80])) ? $trans[80]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[81]', (isset($trans[81])) ? $trans[81]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[82]', (isset($trans[82])) ? $trans[82]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[83]', (isset($trans[83])) ? $trans[83]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[84]', (isset($trans[84])) ? $trans[84]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[85]', (isset($trans[85])) ? $trans[85]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[86]', (isset($trans[86])) ? $trans[86]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[87]', (isset($trans[87])) ? $trans[87]->getTarget() : null) ?><br />
        <label></label><?php echo input_tag('trans[88]', (isset($trans[88])) ? $trans[88]->getTarget() : null) ?><br />
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/profilepages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/profilepage?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/profilepage?culture=pl') ?>&nbsp;</li>
  </ul>
</div>