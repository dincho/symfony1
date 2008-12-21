<?php use_helper('dtForm', 'Javascript') ?>

<?php echo __('Please describe what\'s not working or how we could improve our service:') ?>
<?php echo form_tag('content/reportBug', array('id' => 'report_bug')) ?>
    <fieldset>
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject', null, array('class' => 'input_text_width', 'size' => 25)) ?><br />
        <?php echo pr_label_for('description', 'Description:') ?>
        <?php echo textarea_tag('description', null, array('id' =>'description', 'class' => 'text_area', 'rows' => 15, 'cols' => 60)) ?>
    </fieldset>
    <?php echo link_to_function(__('Cancel and go back to previous page'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
</form>