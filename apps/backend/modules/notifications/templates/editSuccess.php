<?php use_helper('Object', 'dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('notifications/edit', 'class=form') ?>
    <?php echo object_input_hidden_tag($notification, 'getId', array('class' => 'hidden')); ?>
    <?php echo object_input_hidden_tag($notification, 'getCatId', array('class' => 'hidden')); ?>

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

      <label for="catalog">Catalog:</label>
      <var><?php echo $notification->getCatalogue(); ?></var><br />

      <label for="name">Name:</label>
      <?php echo object_input_tag($notification, 'getName', array('class' => 'wide ' . error_class('name',
              true))) ?><br />

      <label for="send_from">Send from address:</label>
      <?php echo object_input_tag($notification, 'getSendFrom', array('class' => 'wide ' . error_class('send_from',
              true))) ?>

      <label for="mail_config">Mail Config:</label>
      <?php echo select_tag('mail_config', options_for_select($mail_options, $notification->getMailConfig()),
                                        array('class' => 'wide ' . error_class('mail_config', true))); ?>
      <br />

      <?php if( $notification->getToAdmins() ): ?>
          <label for="send_to">Send to address:</label>
          <?php echo object_input_tag($notification, 'getSendTo', error_class('send_to')) ?><br />
      <?php endif; ?>

      <label for="bcc">Bcc:</label>
      <?php echo object_input_tag($notification, 'getBcc', array('class' => 'wide ' . error_class('bcc',
              true))) ?><br />

      <label for="subject">Subject:</label>
      <?php echo object_input_tag($notification, 'getSubject', array('class' => 'wide ' . error_class('subject',
              true))) ?><br />

      <hr />

      <label for="notification_body">Body:</label>
      <?php echo textarea_tag('notification_body', $notification->getBody(), array('cols' => 90, 'rows' => 10)) ?><br />
      <label for="notification_body">Footer:</label>
      <?php echo textarea_tag('notification_footer', $notification->getFooter(), array('cols' => 90, 'rows' => 5)) ?><br />

    </fieldset>

    <fieldset class="actions">
        <?php echo button_to('Cancel', 'notifications/list?cancel=1&to_admins=' . (int) $notification->getToAdmins(). '&cat_id='. $notification->getCatId())  . submit_tag('Save', 'class=button') ?>
    </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'notifications/edit?id=' . $notification->getId())); ?>
