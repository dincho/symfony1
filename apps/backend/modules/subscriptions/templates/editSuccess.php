<?php use_helper('Object', 'dtForm', 'Number') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('subscriptions/edit', 'class=form') ?>
  
  <div class="legend">Editing subscriptions</div>
    <div class="subscription_container" style="border: none;">  
      <fieldset class="form_fields">
        
        <label for="limit_label">&nbsp;</label><br />
        
        <label for="post_photo">Create Profile:</label><br />
        
        <label for="post_photo">Post a photo:</label><br />
        
        <label for="send_wink">Send &amp; receive winks:</label><br />
        
        <label for="read_messages">Read new messages:</label><br />
        
        <label for="reply_messages">Respond to messages:</label><br />
        
        <label for="send_messages">Send Messages:</label><br />
        
        <label for="see_viewed">See who`s viewed your profile:</label><br />
        
        <label for="contact_assistant">Contact Online Assistant:</label><br />
        
        <label for="pre_approve">Pre-Approval:</label><br />
        
        <hr style="width: auto;" />
        <label class="period_label" style="width:60px" >First&nbsp;</label>
        <?php echo object_input_tag($sub1, 'getTrial1Period', 'class=period_input_left') ?>
        <?php echo pr_select_payment_period_type('trial1_period_type', $sub1->getTrial1PeriodType(), array('style' => 'width: 80px')) ?>
        <br />
        
        <!--  PERIOD 2 -->
        <label class="period_label" style="width:60px">Next&nbsp;</label>
        <?php echo object_input_tag($sub1, 'getTrial2Period', 'class=period_input_left') ?>
        <?php echo pr_select_payment_period_type('trial2_period_type', $sub1->getTrial2PeriodType(), array('style' => 'width: 80px')) ?>
        <br />
        
        <!--  PERIOD 3 -->
        <label class="period_label" style="width:60px">After that&nbsp;</label>
        <?php echo object_input_tag($sub1, 'getPeriod', 'class=period_input_left') ?>
        <?php echo pr_select_payment_period_type('period_type', $sub1->getPeriodType(), array('style' => 'width: 80px')) ?> 
        <br />
              
      </fieldset>
  </div>        
  <?php foreach($subscriptions as $sub): ?>
  <div class="subscription_container">
      <fieldset class="form_fields">
        <var><b><?php echo $sub->getTitle() ?></b></var><br /><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanCreateProfile', array('control_name' => 'subs['. $sub->getId() .'][can_create_profile]')) ?>
        <?php echo object_input_tag($sub, 'getCreateProfiles', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][create_profiles]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanPostPhoto', array('control_name' => 'subs['. $sub->getId() .'][can_post_photo]')) ?>
        <?php echo object_input_tag($sub, 'getPostPhotos', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][post_photos]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanWink', array('control_name' => 'subs['. $sub->getId() .'][can_wink]')) ?>
        <?php echo object_input_tag($sub, 'getWinks', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][winks]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanReadMessages', array('control_name' => 'subs['. $sub->getId() .'][can_read_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReadMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][read_messages]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanReplyMessages', array('control_name' => 'subs['. $sub->getId() .'][can_reply_messages]')) ?>
        <?php echo object_input_tag($sub, 'getReplyMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][reply_messages]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanSendMessages', array('control_name' => 'subs['. $sub->getId() .'][can_send_messages]')) ?>
        <?php echo object_input_tag($sub, 'getSendMessages', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][send_messages]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanSeeViewed', array('control_name' => 'subs['. $sub->getId() .'][can_see_viewed]')) ?>
        <?php echo object_input_tag($sub, 'getSeeViewed', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][see_viewed]')) ?><br />
        
        <?php echo object_bool_select_tag($sub, 'getCanContactAssistant', array('control_name' => 'subs['. $sub->getId() .'][can_contact_assistant]')) ?>
        <?php echo object_input_tag($sub, 'getContactAssistant', array('class' => 'limit_input', 'control_name' => 'subs['. $sub->getId() .'][contact_assistant]')) ?><br />
        
        <?php echo object_checkbox_tag($sub, 'getPreApprove', array('control_name' => 'subs['. $sub->getId() .'][pre_approve]') ) ?><br />
      
      <hr style="width: 140px;" />
<!--      <hr style="width: auto;" />-->
	  <?php echo input_tag('subs['. $sub->getId() .'][trial1_amount]', format_currency($sub->getTrial1Amount()), array('class' => 'limit_input', 'style' => 'float: left')) ?>
	  <label class="period_label">&pound;</label><br />
	  
	  <?php echo input_tag('subs['. $sub->getId() .'][trial2_amount]', format_currency($sub->getTrial2Amount()), array('class' => 'limit_input', 'style' => 'float: left')) ?>
	  <label class="period_label">&pound;</label><br />
	  
	  <?php echo input_tag('subs['. $sub->getId() .'][amount]', format_currency($sub->getAmount()), array('class' => 'limit_input', 'style' => 'float: left')) ?>
	  <label class="period_label">&pound;</label><br />
    </fieldset>
  </div>
  <?php endforeach; ?>
  <br />
  
  <div class="actions">
    <?php echo button_to('Cancel', 'subscriptions/list')  . submit_tag('Save', 'class=button') ?>
  </div>
</form>
