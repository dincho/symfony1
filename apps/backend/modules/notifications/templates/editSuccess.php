<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('notifications/edit', 'class=form') ?>
    <?php echo input_hidden_tag('id', $notification->getId(), 'class=hidden') ?>
    <div class="legend"><?php echo $notification->getName() ?></div>
    <fieldset class="form_fields">
    
    <div class="float-right" style="margin-right: 20px;">
        <label>Trigger:</label><var><?php echo $notification->getTriggerName() ?></var><br />
        <label>&nbsp;</label>
        <?php echo object_bool_select_tag($notification, 'getIsActive', array(1 => 'On', 0 => 'Off')) ?>
        <?php echo object_input_tag($notification, 'getDays', array('class' => 'mini')) ?>Days
        <?php echo radiobutton_tag('whn', 'B', $notification->getWhn() == 'B', array('style' => 'float: none;display: inline;')) ?>Before
        <?php echo radiobutton_tag('whn', 'A', $notification->getWhn() == 'A', array('style' => 'float: none;display: inline;')) ?>After
    </div>
    
        <label for="name">Name:</label>
        <?php echo object_input_tag($notification, 'getName', error_class('name')) ?><br />

        <label for="send_from">Send from address:</label>
        <?php echo object_input_tag($notification, 'getSendFrom', error_class('send_from')) ?><br />
        
        <?php if( $notification->getToAdmins() ): ?>
            <label for="send_to">Send to address:</label>
            <?php echo object_input_tag($notification, 'getSendTo', error_class('send_to')) ?><br />
        <?php endif; ?>
        
        <label for="bcc">Bcc:</label>
        <?php echo object_input_tag($notification, 'getBcc', error_class('bcc')) ?><br />
        
        <label for="subject">Subject:</label>
        <?php echo object_input_tag($notification, 'getSubject', error_class('subject')) ?><br />
        
        <hr />
            
        <label for="notification_body">Body:</label>
        <?php echo textarea_tag('notification_body', $notification->getBody(), array('cols' => 90, 'rows' => 10)) ?><br />
        <label for="notification_body">Footer:</label>
        <?php echo textarea_tag('notification_footer', $notification->getFooter(), array('cols' => 90, 'rows' => 5)) ?><br />
    </fieldset>
    

    
    <fieldset class="actions">
        <?php echo button_to('Cancel', 'notifications/list?cancel=1&to_admins=' . $notification->getToAdmins())  . submit_tag('Save', 'class=button') ?>
    </fieldset>

</form>
