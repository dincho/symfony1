<?php use_helper('dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php include_partial('sysMsgTopMenu', array('catalog' => $catalog)); ?>
<br />

<?php echo form_tag('content/systemMessage', 'class=form') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), array('class' => 'hidden', )) ?>
    <?php echo input_hidden_tag('headline_id', $headline->getMsgCollectionId(), array('class' => 'hidden', )) ?>
    <?php echo input_hidden_tag('content_id', $content->getMsgCollectionId(), array('class' => 'hidden', )) ?>
    
    <div class="legend"><?php echo $headline->getSource(); ?></div>
    <fieldset class="form_fields">
        <label for="catalog">Catalog</label>
        <var><?php echo $catalog; ?></var><br /><br />
        
        <label>Headline</label><?php echo input_tag('headline', $headline->getTarget(), array('id' => 'tu_headline')) ?><br />
        <label>Content</label><?php echo textarea_tag('content', $content->getTarget(), array('cols' => 80, 'rows' => 10, 'id' => 'tu_content')) ?><br />
    </fieldset>
    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'content/systemMessages?cancel=1&cat_id=1')  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'content/systemMessage?headline_id=' . $headline->getMsgCollectionId() . '&content_id=' . $content->getMsgCollectionId())); ?>