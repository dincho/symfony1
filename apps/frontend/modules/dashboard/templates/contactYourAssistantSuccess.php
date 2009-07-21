<?php use_helper('dtForm') ?>
<?php $photo_tag = ''?>

<?php if( $photo ): ?>
    <?php $photo_tag = image_tag( ($photo->getImageUrlPath('cropped', '70x105')) ? $photo->getImageUrlPath('cropped', '70x105') : $photo->getImageUrlPath('file', '70x105')) ?>
<?php endif; ?>  

<?php echo __('Assistant request headline') ?>
<?php echo form_tag('dashboard/contactYourAssistant', array('id' => 'report_bug')) ?>
    <fieldset>
        <div id="assistant_right">
            <?php echo strtr(__('Assistant request content'), array('%ASSISTANT_IMAGE%' => $photo_tag)) ?>
        </div>  
            
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject', null, array('class' => 'input_text_width', 'size' => 25)) ?><br />
        <?php echo pr_label_for('description', 'Description:') ?>
        <?php echo textarea_tag('description', null, array('id' =>'description', 'class' => 'text_area', 'rows' => 16, 'cols' => 52)) ?>
    </fieldset>
    
    <div class="actions">
        <?php echo link_to(__('Cancel and go back to previous page'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
    </div>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>