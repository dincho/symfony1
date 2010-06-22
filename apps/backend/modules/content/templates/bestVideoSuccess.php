<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/bestVideo', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden')); ?>
    <div class="legend">Edit Best Video Template</div>
    <fieldset class="form_fields">
        <label for="Header">Header</label>
        <?php echo textarea_tag('Header', (isset($template)) ? $template->getHeader() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
        <label for="Body winner">Body winner</label>
        <?php echo textarea_tag('BodyWinner', (isset($template)) ? $template->getBodyWinner() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
        <label for="Footer">Footer</label>
        <?php echo textarea_tag('Footer', (isset($template)) ? $template->getFooter() : null, array('cols' => 70, 'rows' => 6)) ?><br />
        
    </fieldset>
    
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/bestVideo?cancel=1&cat_id=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/bestVideo')); ?>