<?php use_helper('Object', 'dtForm', 'Number') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('subscriptions/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($sub1, 'getCatId'); ?>

  <div class="legend">Edit subscriptions: <?php echo $sub1->getCatalogue(); ?></div>
    <div class="subscription_container" style="border: none;">
      <fieldset class="form_fields">

        <label for="limit_label" style="height: 40px; margin: 0">&nbsp;</label><br />

        <label for="post_photo">Create Profile:</label><br />

        <label for="post_photo">Post a photo:</label><br />

        <label for="post_private_photo">Post a private photo:</label><br />

        <label for="send_wink">Send &amp; receive winks:</label><br />

        <label for="read_messages">Read new messages:</label><br />

        <label for="reply_messages">Respond to messages:</label><br />

        <label for="send_messages">Send Messages:</label><br />

        <label for="see_viewed">See who`s viewed your profile:</label><br />

        <label for="contact_assistant">Contact Online Assistant:</label><br />

        <label for="pre_approve">Pre-Approval:</label><br />

        <hr style="width: auto;" />

        <label>Price:&nbsp;</label><br />

        <br /><br /><br />

      </fieldset>
  </div>
  <?php foreach($subscriptions as $i => $sub): ?>
  <div class="subscription_container">
      <fieldset class="form_fields">
        <var><b><?php echo $sub->getTitle() ?></b></var><br />
        <var>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monthly&nbsp;&nbsp;&nbsp;&nbsp;Daily</var><br />
        <?php echo object_bool_select_tag($sub, 'getCanCreateProfile', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_create_profile]')) ?>
        <?php echo object_input_tag($sub, 'getCreateProfiles', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][create_profiles]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanPostPhoto', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_post_photo]')) ?>
        <?php echo object_input_tag($sub, 'getPostPhotos', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][post_photos]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanPostPrivatePhoto', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_post_private_photo]')) ?>
        <?php echo object_input_tag($sub, 'getPostPrivatePhotos', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][post_private_photos]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanWink', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_wink]')) ?>
        <?php echo object_input_tag($sub, 'getWinks', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][winks]')) ?>
        <?php echo object_input_tag($sub, 'getWinksDay', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][winks_day]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanReadMessages', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_read_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReadMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][read_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReadMessagesDay', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][read_messages_day]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanReplyMessages', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_reply_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReplyMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][reply_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReplyMessagesDay', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][reply_messages_day]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanSendMessages', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_send_messages]')) ?>
        <?php echo object_input_tag($sub, 'getSendMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][send_messages]')) ?>
        <?php echo object_input_tag($sub, 'getSendMessagesDay', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][send_messages_day]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanSeeViewed', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_see_viewed]')) ?>
        <?php echo object_input_tag($sub, 'getSeeViewed', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][see_viewed]')) ?><br />

        <?php echo object_bool_select_tag($sub, 'getCanContactAssistant', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][can_contact_assistant]')) ?>
        <?php echo object_input_tag($sub, 'getContactAssistant', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][contact_assistant]')) ?>
        <?php echo object_input_tag($sub, 'getContactAssistantDay', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getSubscriptionId() .'][contact_assistant_day]')) ?><br />

        <?php echo object_checkbox_tag($sub, 'getPreApprove', array('control_name' => 'subs['. $sub->getSubscriptionId() .'][pre_approve]', 'class' => 'checkbox') ) ?><br />

        <hr style="width: 140px;" />
            <?php if( $sub->getSubscriptionId() != 1 ): ?>
            <?php echo input_tag('subs['. $sub->getSubscriptionId() .'][amount]', format_currency($sub->getAmount()), array('class' => 'limit_input', 'style' => 'float: left')) ?>
            <?php echo select_tag('subs['. $sub->getSubscriptionId() .'][currency]',
                                            options_for_select(array('GBP' => 'GBP', 'PLN' => 'PLN', 'USD' => 'USD', ), $sub->getCurrency()), array('class' => '', 'style' => 'width: 60px; float: left')) ?>
            <label class="period_label">/</label>

            <?php echo input_tag('subs['. $sub->getSubscriptionId() .'][period]', $sub->getPeriod(), 'class=period_input_left') ?>
            <?php echo pr_select_payment_period_type('subs['. $sub->getSubscriptionId() .'][period_type]', $sub->getPeriodType(), array('style' => 'width: 80px')) ?>
        <?php endif; ?>
        <br />

    </fieldset>
  </div>
  <?php endforeach; ?>
  <br />
  <div class="actions">
    <?php echo button_to('Cancel', 'subscriptions/list')  . submit_tag('Save', 'class=button') ?>
  </div>
</form>
