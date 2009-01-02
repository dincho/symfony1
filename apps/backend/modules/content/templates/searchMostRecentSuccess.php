<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/searchMostRecent', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Most Recent</div>
    <fieldset class="form_fields">
        <label for="culture">Language</label>
        <var><?php echo  format_language($culture) ?></var><br />
        
        <label for="trans_12">Instructions</label>
        <?php echo textarea_tag('trans[12]', (isset($trans[12])) ? $trans[12]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="search_rows_most_recent">Display Rows</label>
        <?php echo input_tag('search_rows_most_recent', sfConfig::get('app_settings_search_rows_most_recent'), array('class' => 'mini')) ?><br />
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/searchpages?cancel=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/searchMostRecent?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/searchMostRecent?culture=pl') ?>&nbsp;</li>
  </ul>
</div>