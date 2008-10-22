<?php use_helper('dtForm') ?>

<?php echo __('I\'d like tell my friend about PolishRomance.com') ?>
<?php echo form_tag('content/tellFriend', array('id' => 'tell_a_friend_container')) ?>
    <fieldset>
        <legend><?php echo __('Your Friend\'s Information') ?></legend>
        <?php echo pr_label_for('friend_email', 'Email') ?>
        <?php echo input_tag('friend_email') ?><Br />
        
        <?php echo pr_label_for('friend_full_name', 'Full Name') ?>
        <?php echo input_tag('friend_full_name') ?>
    </fieldset>
    <fieldset>
        <legend><?php echo __('Your Information') ?></legend>
        <?php echo pr_label_for('email', 'Email') ?>
        <?php echo input_tag('email') ?><br />
        
        <?php echo pr_label_for('full_name', 'Full Name') ?>
        <?php echo input_tag('full_name') ?><br />
        
        <?php echo pr_label_for('comments', 'Comments <span>(optional)<span>') ?>
        <?php echo textarea_tag('comments', null, array('rows' => 4, 'cols' => 20)) ?>
    </fieldset>
    <div id="tell_a_friend_div">
        <strong><?php echo __('Our Privacy Policy') ?></strong><br />
        <?php echo __('To assure your friend\'s confidentiality:') ?><br />
        &bull;&nbsp;<?php echo __('We will only contact your friend once.') ?><br />
        &bull;&nbsp;<?php echo __('We will not use your friend\'s contact information for any other purpose.') ?><br />
        &bull;&nbsp;<?php echo __('We will not save your friend\'s contact information.') ?><br />
        &bull;&nbsp;<?php echo __('We will not forward your friend\'s contact information to any other organization.') ?><br />
    </div>
    <span class="tell_friend_footer">
        <?php echo link_to(__('Cancel and go back to previous page'), 'dashboard/index', array('class' => 'sec_link_small')) ?><br />
        <?php echo submit_tag('', array('class' => 'send_friend')) ?>    
    </span>
</form>