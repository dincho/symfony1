<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php echo __('Finally, a few words straight from your heart:') ?>
<?php echo form_tag('registration/essay', array('id' => 'essay')) ?>
    <fieldset>
        <?php echo pr_label_for('headline', 'Headline:') ?><br />
        <?php echo object_input_tag($member, 'getEssayHeadline', array('class' => 'essay', 'size' => 30) ) ?><br /><br />
        
        <?php echo pr_label_for('introduction', 'Introduction:') ?><br />
        <?php echo object_textarea_tag($member, 'getEssayIntroduction', array('cols'=> 60, 'rows' => 11, 'class' => 'essay', 'id' => 'introduction', 'maxlength' => 2500)) ?><br />
        <?php echo submit_tag(__('Save and Continue'), array('class' => 'button')) ?>
    </fieldset>
    <div id="tips">
        <strong><?php echo __('Helpful Tips') ?></strong><br /><br />
        <?php echo __('Women look at essay and pictures. So do men. Therefore write whatever is on your heart and:') ?>
        <ul>
            <li><?php echo __('Write about how you spend time off, about interests, hobbies, vacations etc.') ?></li>
            <li><?php echo __('Write about your job, plans for the future, successes.') ?></li>
            <li><?php echo __('BE POSITIVE, never negative: don\'t mention your bad experience, disastrous marriages or past relationships.') ?></li>
            <li><?php echo __('BE SPECIFIC: choose one, favorite topic (for instance your favorite pet, best concert, etc.) and write in details about it. And finally...') ?></li>
            <li><?php echo __('BE HONEST &amp; COOL. Take your time. You\'ll do great!') ?></li>
        </ul>
        <?php echo link_to(__('more tips'), '@page?slug=writing_tips', array('class' => 'sec_link_small')) ?>
    </div>
</form>
<br class="clear" />
<span><?php echo __('Note: You will be able to change this information later.') ?></span>
<?php echo javascript_tag('parseCharCounts();') ?>