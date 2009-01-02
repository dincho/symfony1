<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/imbraReport', 'class=form') ?>
    <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
    <div class="legend">Edit IMBRA Report Template</div>
    <fieldset class="form_fields">
        <?php foreach($imbra_questions as $imbra_question): ?>
            <label class="full_row"><?php echo strip_tags($imbra_question->getTitle()) ?></label><br />
            
            <?php if( !$imbra_question->getOnlyExplain()): ?>
                <label>Positive Answer</label>
                <?php echo textarea_tag('answers[positive][' . $imbra_question->getId() . ']', $imbra_question->getPositiveAnswer(), array('cols' => 60, 'rows' => 3)) ?><br />
                
                <label>Negative Answer</label>
                <?php echo textarea_tag('answers[negative][' . $imbra_question->getId() . ']', $imbra_question->getNegativeAnswer(), array('cols' => 60, 'rows' => 3)) ?><br />
            <?php else: ?>
                <label></label>
                <?php echo textarea_tag('answers[positive][' . $imbra_question->getId() . ']', $imbra_question->getPositiveAnswer(), array('cols' => 60, 'rows' => 3)) ?><br />
            <?php endif; ?>
        <?php endforeach; ?>
    </fieldset>
        
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/imbrapages?cancel=1&culture=' . $culture)  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'content/imbraReport?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'content/imbraReport?culture=pl') ?>&nbsp;</li>
  </ul>
</div>