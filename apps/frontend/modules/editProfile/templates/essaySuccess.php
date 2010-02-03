<?php use_helper('Object', 'dtForm', 'Javascript') ?>

<?php echo __('You may change your essay here.') ?><br />
<span><?php echo __("Make changes and click Save.") ?></span>

                
<?php echo form_tag('editProfile/essay', array('id' => 'essay')) ?>

    <?php if( $sf_user->getCulture() == 'pl'): ?>
      <div id="tips" style="margin-top: 87px;">
    <?php else: ?>
      <div id="tips">
    <?php endif; ?>
      <?php echo __('Essay Helpful Tips - edit'); ?>
    </div>
    
    <fieldset>
        <?php echo pr_label_for('essay_headline', __('Headline:') . '<span style="color:red;">*</span>') ?><br />
        <?php echo input_tag('essay_headline', strip_tags($member->getEssayHeadline(ESC_RAW)), array('class' => 'essay', 'size' => 30, 'maxlength' => 60))?><br /><br />

        <?php if( $sf_user->getCulture() == 'pl'): ?>
        <div id="essay_polish_letters">
            <?php echo link_to_function('ą', 'pl_letter_press("ą")') ?>
            <?php echo link_to_function('ć', 'pl_letter_press("ć")') ?>
            <?php echo link_to_function('ę', 'pl_letter_press("ę")') ?>
            <?php echo link_to_function('ł', 'pl_letter_press("ł")') ?>
            <?php echo link_to_function('ń', 'pl_letter_press("ń")') ?>
            <?php echo link_to_function('ó', 'pl_letter_press("ó")') ?>
            <?php echo link_to_function('ś', 'pl_letter_press("ś")') ?>
            <?php echo link_to_function('ż', 'pl_letter_press("ż")') ?>
            <?php echo link_to_function('ź', 'pl_letter_press("ź")') ?>
        </div><br />
        <?php endif; ?>
                        
        <?php echo pr_label_for('introduction', __('Introduction:') . '<span style="color:red;">*</span>') ?><br />
        <?php echo object_textarea_tag($member, 'getEssayIntroduction', 
                                                 array('cols'=> 60, 
                                                        'rows' => 11, 
                                                        'class' => 'essay', 
                                                        'id' => 'introduction',
                                                        'onfocus' => 'active_field = this',
                                                        'maxlength' => 2500
                                                 )) ?><br />
    
    </fieldset>
    <fieldset>
        <?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
    </fieldset>
</form>
<br /><br /><br class="clear" />

<?php echo javascript_tag('parseCharCounts();') ?>

<?php echo javascript_tag('
Event.observe(window, "load", function() {
    setTimeout("$(\"essay\").findFirstElement().focus();",1);
});
');?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>