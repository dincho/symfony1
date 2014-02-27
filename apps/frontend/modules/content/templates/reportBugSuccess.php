<?php use_helper('dtForm', 'Javascript') ?>

<?php echo __('Please describe what\'s not working or how we could improve our service:') ?>
<?php echo form_tag('content/reportBug', array('id' => 'report_bug')) ?>
    <fieldset>
        <?php echo pr_label_for('subject', __('Subject:')) ?>
        <?php echo input_tag('subject') ?><br />
        
        <?php echo pr_label_for('description', __('Description:')) ?>
        <?php echo textarea_tag('description') ?>
        
        <?php echo input_hidden_tag('tech_info') ?>
    </fieldset>
    <fieldset class="actions">
        <?php echo submit_tag(__('Send'), array('class' => 'button')) ?>
        <?php echo link_to_function(__('Cancel'), 'window.history.go(-1)', array('class' => 'button')) ?>
    </fieldset>
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())) ?>
<?php end_slot(); ?>

<script type="text/javascript" charset="utf-8">
    Event.observe(window, 'load', function() {
        
        var info = "User Agent: " + navigator.userAgent + "\n";
        info += "Cookies Enabled: " + navigator.cookieEnabled + "\n";
        info += "Screen Resolution: " + screen.width + "x" +  screen.height + "\n";
        info += "Color Depth: " + screen.colorDepth + "\n";
        info += "Window Size: " + document.documentElement.clientWidth + "x" + document.documentElement.clientHeight + "\n";
        info += "Flash: " + ((FlashDetect.installed) ? FlashDetect.raw : "not installed") + "\n";
        
        $('tech_info').value = info;
    });
</script>