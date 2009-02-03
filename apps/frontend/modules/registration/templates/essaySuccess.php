<?php use_helper('Object', 'dtForm', 'Javascript') ?>


<?php echo __('Essay instructions') ?>
<?php echo form_tag('registration/essay', array('id' => 'essay')) ?>
    <fieldset>
        <?php echo pr_label_for('headline', 'Headline:') ?><br />
        <?php echo object_input_tag($member, 'getEssayHeadline', array('class' => 'essay', 'size' => 30) ) ?><br /><br />
        
        <?php echo pr_label_for('introduction', 'Introduction:') ?><br />
        <?php echo object_textarea_tag($member, 'getEssayIntroduction', array('cols'=> 60, 'rows' => 11, 'class' => 'essay', 'id' => 'introduction', 'maxlength' => 2500)) ?><br />
        <?php echo submit_tag(__('Save and Continue'), array('class' => 'button')) ?>
    </fieldset>
    <div id="tips"><?php echo __('Essay content', array('%URL_FOR_WRITING_TIPS%' => url_for('@page?slug=writing_tips'))) ?></div>
</form>
<br class="clear" />
<br />
<span><?php echo __('Essay note') ?></span>
<?php echo javascript_tag('parseCharCounts();') ?>