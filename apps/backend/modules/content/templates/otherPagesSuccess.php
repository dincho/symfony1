<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/otherPages', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Other Pages</div>
    <fieldset class="form_fields">
        <label for="culture">Language</label>
        <var><?php echo format_language($culture) ?></var><br />
    </fieldset>
    
    <fieldset class="form_fields error_msgs_fields">
        <label>Error Messages</label>
        <?php foreach ($trans as $msg_coll_id => $tran): ?>
            <?php echo input_tag('trans['.$msg_coll_id.']', $tran->getTarget()) ?><br />
        <?php endforeach; ?>
        
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/otherPages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/otherPages?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/otherPages?culture=pl') ?>&nbsp;</li>
  </ul>
</div>