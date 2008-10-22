<?php use_helper('Object', 'dtForm', 'Number') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('subscriptions/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($sub, 'getId', 'class=hidden') ?>
  
  <div class="legend">Editing subscription: <?php echo $sub->getTitle() ?></div>
  <fieldset class="form_fields">
    
    <label for="limit_label">&nbsp;</label>
    <label for="limits" id="limit_label">Limit</label><br />
    
    <label for="post_photo">Post a photo:</label>
    <?php echo object_bool_select_tag($sub, 'getCanPostPhoto') ?>
    <?php echo object_input_tag($sub, 'getPostPhotos', 'class=limit_input') ?><br />
    
    <label for="send_wink">Send &amp; receive winks:</label>
    <?php echo object_bool_select_tag($sub, 'getCanWink') ?>
    <?php echo object_input_tag($sub, 'getWinks', 'class=limit_input') ?><br />
    
    <label for="read_messages">Read new messages:</label>
    <?php echo object_bool_select_tag($sub, 'getCanReadMessages') ?>
    <?php echo object_input_tag($sub, 'getReadMessages', 'class=limit_input') ?><br />
    
    <label for="reply_messages">Respond to messages:</label>
    <?php echo object_bool_select_tag($sub, 'getCanReplyMessages') ?>
    <?php echo object_input_tag($sub, 'getReplyMessages', 'class=limit_input') ?><br />
    
    <label for="send_messages">Send Messages:</label>
    <?php echo object_bool_select_tag($sub, 'getCanSendMessages') ?>
    <?php echo object_input_tag($sub, 'getSendMessages', 'class=limit_input') ?><br />
    
    <label for="see_viewed">See who`s viewed your profile:</label>
    <?php echo object_bool_select_tag($sub, 'getCanSeeViewed') ?>
    <?php echo object_input_tag($sub, 'getSeeViewed', 'class=limit_input') ?><br />
    
    <label for="contact_assistant">Contact Online Assistant:</label>
    <?php echo object_bool_select_tag($sub, 'getCanContactAssistant') ?>
    <?php echo object_input_tag($sub, 'getContactAssistant', 'class=limit_input') ?><br />
    
    <label for="pre_approve">Pre-Approval</label>
    <?php echo object_checkbox_tag($sub, 'getPreApprove') ?><br />
  </fieldset>
  <hr />
  
  <fieldset class="form_fields subscription_periods">
    <!--  PERIOD 1 -->
	  <label>From</label>
	  <?php echo object_input_tag($sub, 'getPeriod1From', 'class=period_input') ?>
	  
	  <label>month(s) to</label>
	  <?php echo object_input_tag($sub, 'getPeriod1To', 'class=period_input') ?>
	  <label>month(s)&nbsp;&nbsp;</label>
	  
	  <?php echo input_tag('period1_price', format_currency($sub->getPeriod1Price()), 'class=limit_input') ?>
	  <label>&pound;</label><br />
	  
	  <!--  PERIOD 2 -->
	  <label>From</label>
	  <?php echo object_input_tag($sub, 'getPeriod2From', 'class=period_input') ?>
	  
	  <label>month(s) to</label>
	  <?php echo object_input_tag($sub, 'getPeriod2To', 'class=period_input') ?>
	  <label>month(s)&nbsp;&nbsp;</label>
	  
	  <?php echo input_tag('period2_price', format_currency($sub->getPeriod2Price()), 'class=limit_input') ?>
	  <label>&pound;</label><br />
	  
	  <!--  PERIOD 3 -->
	  <label>From</label>
	  <?php echo object_input_tag($sub, 'getPeriod3From', 'class=period_input') ?>
	  
	  <label>month(s) to</label>
	  <?php echo object_input_tag($sub, 'getPeriod3To', 'class=period_input') ?>
	  <label>month(s)&nbsp;&nbsp;</label>
	  
	  <?php echo input_tag('period3_price', format_currency($sub->getPeriod3Price()), 'class=limit_input') ?>
	  <label>&pound;</label><br />
  </fieldset>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'subscriptions/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
