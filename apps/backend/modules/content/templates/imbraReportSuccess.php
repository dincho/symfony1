<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/imbraReport', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden')); ?>
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
        <?php echo button_to('Cancel', 'content/imbrapages?cancel=1&cat_id=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/imbraReport')); ?>
