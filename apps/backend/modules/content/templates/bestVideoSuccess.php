<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/bestVideo', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit Best Video Template</div>
    <fieldset class="form_fields">
        <label for="Header">Header</label>
        <?php echo textarea_tag('Header', (isset($video)) ? $video->getHeader() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
        <label for="Body winner">Body winner</label>
        <?php echo textarea_tag('BodyWinner', (isset($video)) ? $video->getBodyWinner() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
        <label for="Footer">Footer</label>
        <?php echo textarea_tag('Footer', (isset($video)) ? $video->getFooter() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
    </fieldset>
    
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/bestVideo?cancel=1&culture=' . $culture)  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/bestVideo?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/bestVideo?culture=pl') ?>&nbsp;</li>
  </ul>
</div>