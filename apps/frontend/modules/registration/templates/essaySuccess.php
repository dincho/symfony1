<?php use_helper('Object', 'dtForm', 'Javascript') ?>


<?php echo __('Essay instructions') ?>
<?php echo form_tag('registration/essay', array('id' => 'essay')) ?>
    <fieldset>
        <?php echo pr_label_for('essay_headline', __('Headline:')) ?><br />
        <?php echo object_input_tag($member, 'getEssayHeadline', array('class' => 'essay', 'size' => 30, 'maxlength' => 50) ) ?><br /><br />

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
                
        <?php echo pr_label_for('introduction', __('Introduction:')) ?><br />
        <?php echo object_textarea_tag($member, 'getEssayIntroduction', 
                                       array('cols'=> 60, 'rows' => 11, 'class' => 'essay', 
                                       'id' => 'introduction', 'maxlength' => 2500,
                                       'onfocus' => 'active_field = this',
                                       )) ?><br />
        <?php echo submit_tag(__('Save and Continue'), array('class' => 'button')) ?>
    </fieldset>
    <?php if( $sf_user->getCulture() == 'pl'): ?>
    <div id="tips" style="margin-top: 87px;">
    <?php else: ?>
    <div id="tips">
    <?php endif; ?>
        <?php echo __('Essay content', array('%URL_FOR_WRITING_TIPS%' => url_for('@page?slug=writing_tips'))) ?>
    </div>
</form>
<br class="clear" />
<br />
<span><?php echo __('Essay note') ?></span>
<?php echo javascript_tag('parseCharCounts();') ?>