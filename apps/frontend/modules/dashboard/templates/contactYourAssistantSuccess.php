<?php use_helper('dtForm') ?>

<?php echo __('If you need immediate help, please check <a href="{HELP_URL}" class="sec_link">Help</a>. We usually respond within 24 hours.', array('{HELP_URL}' => url_for('@page?slug=help'))) ?>
<?php echo form_tag('dashboard/contactYourAssistant', array('id' => 'report_bug')) ?>
    <fieldset>
        <div id="assistant_right">
            <?php echo __('Studies show there is a 95% chance other members already asked the same question. So before you write, review these questions and answers.') ?><br />
            <?php echo link_to(__('I forgot my password'), '@page?slug=help#1', 'class=sec_link') ?><br />
            <?php echo link_to(__('I cannot contact other member, even though I\'m logged in.'), '@page?slug=help#2', 'class=sec_link') ?><br />
            <?php echo link_to(__('Special note to AOL users'), '@page?slug=help#3', 'class=sec_link') ?><br />
            <?php echo link_to(__('How do I sing up?'), '@page?slug=help#4', 'class=sec_link') ?><br />
            <?php echo link_to(__('How do I unsubscribe?'), '@page?slug=help#5', 'class=sec_link') ?><br />
            <?php echo link_to(__('Can I delete my account?'), '@page?slug=help#6', 'class=sec_link') ?><br />
            <?php echo link_to(__('... more questions and answers'), '@page?slug=help', 'class=sec_link') ?><br />
            <div id="assistant_profile">
                <?php echo image_tag('pic/banner_assistant.jpg') ?>
                <p><?php echo __('Still can’t find the answer? Please write me a message. I’ll do my best to respond within 24 hours. Good Luck!<br /><br />Agnieszka, Online Assistant') ?></p>
            </div>
        </div>  
            
        <?php echo pr_label_for('subject', 'Subject:') ?>
        <?php echo input_tag('subject', null, array('class' => 'input_text_width', 'size' => 25)) ?><br />
        <?php echo pr_label_for('description', 'Description:') ?>
        <?php echo textarea_tag('description', null, array('id' =>'description', 'class' => 'text_area', 'rows' => 16, 'cols' => 52)) ?>
    </fieldset>

    <?php echo link_to(__('Cancel and go back to previous page'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Send'), array('class' => 'button_mini')) ?>
</form>