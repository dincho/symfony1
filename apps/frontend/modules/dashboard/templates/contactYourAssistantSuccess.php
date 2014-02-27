<?php use_helper('dtForm') ?>
<?php $photo_tag = ''?>

<?php if( $photo ): ?>
    <?php $photo_tag = image_tag( ($photo->getImageUrlPath('cropped', '70x105')) ? $photo->getImageUrlPath('cropped', '70x105') : $photo->getImageUrlPath('file', '70x105')) ?>
<?php endif; ?>  

<?php echo __('Assistant request headline') ?>
<?php echo form_tag('dashboard/contactYourAssistant', array('id' => 'assistant')) ?>
    <fieldset>
        <div id="assistant_right">
            <?php echo strtr(__('Assistant request content'), array('%ASSISTANT_IMAGE%' => $photo_tag)) ?>
        </div>  
            
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject') ?><br />
        
        <?php echo pr_label_for('description', 'Description:') ?>
        <?php echo textarea_tag('description') ?>
    </fieldset>
    
    <fieldset class="actions">
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
        <?php echo button_to(__('Cancel'), 'dashboard/index', array('class' => 'button')) ?><br />
    </fieldset>
</form>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>