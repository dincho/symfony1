<?php use_helper('Object', 'Javascript', 'fillIn') ?>

<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('feedback/compose', 'class=form') ?>

<div class="legend">Compose Email</div>
<fieldset class="form_fields">
  <table class="details float-left">
    <tbody>
      <tr>
        <th>Username</th>
        <td><?php echo input_tag('username', ( isset($selectedMembers) ) ? $selectedMembers : $sf_request->getParameter('username') ) ?></td>
      </tr>
      <tr>
        <th></th>
        <td><?php echo link_to('Search Members', 'feedback/addEmailRecipients') ?></td>
      </tr>
      <tr>
        <th>To Email</th>
        <td><?php echo input_tag('mail_to', $sf_request->getParameter('mail_to')); ?></td>
      </tr>
      <tr>
        <th>Bcc</th>
        <td><?php echo input_tag('bcc', $sf_request->getParameter('bcc', $template->getBcc())) ?></td>
      </tr>
      <tr>
        <th>Template</th>
        <?php $tpl_url = (!$sf_request->hasParameter('id')) ? url_for('feedback/compose?template_id=') : url_for('feedback/reply?id=' . $sf_request->getParameter('id').'&template_id=') ?>
        <td><?php echo object_select_tag($template->getId(), 'template_id', array (
                  'related_class' => 'FeedbackTemplate',
                  'peer_method' => 'doSelect',
                  'include_blank' => true,
                  'onchange' => 'document.location.href = "'. $tpl_url.'/" + this.value + "&mail_to="+document.getElementById("mail_to").value;',
                ))?>
        </td>
      </tr>
      <tr>
        <th>From Email</th>
        <td><?php echo input_tag('mail_from', $sf_request->getParameter('mail_from', $template->getMailFrom())) ?></td>
      </tr>
      <tr>
        <th>Mail Config</th>
        <td><?php echo select_tag('mail_config', options_for_select($mail_options, $sf_request->getParameter('mail_config'))); ?></td>
      </tr>
      <tr>
        <th>Send options</th>
        <td>
            <?php $f = fillIn('send_options[email_address]', 'c', 'email_address', true); ?>
            <?php echo checkbox_tag('send_options[]', 'email_address', $f); ?><label>to email address</label>
            <?php echo checkbox_tag('send_options[]', 'internal_inbox'); ?><label>to internal inbox</label>
        </td>
      </tr>
    <tbody>
  </table>
  <table class="details compose_options float-left">
    <tbody>
      <tr>
        <th>Membership:</th>
        <td><?php echo checkbox_tag('send_filter[subscription_id][]', SubscriptionPeer::FREE, null, array('class' => 'checkbox')) ?></td>
        <th>Standard Members</th>
        <td><?php echo checkbox_tag('send_filter[subscription_id][]', SubscriptionPeer::PREMIUM, null, array('class' => 'checkbox')) ?></td>
        <th>Premium Members</th>        
        <td><?php echo checkbox_tag('send_filter[subscription_id][]', SubscriptionPeer::VIP, null, array('class' => 'checkbox')) ?></td>
        <th>VIP Members</th>        
        <td><?php echo checkbox_tag('send_filter[status_id][]', MemberStatusPeer::ABANDONED, null, array('class' => 'checkbox')) ?></td>
        <th>Abandoned Registration</th>        
      </tr>
      <tr>
        <th>IMBRA Category:</th>
        <td><?php echo checkbox_tag('send_filter[imbra_us]', 1, null, array('class' => 'checkbox')) ?></td>
        <th>US</th>
        <td><?php echo checkbox_tag('send_filter[imbra_non_us]', 1, null, array('class' => 'checkbox')) ?></td>
        <th>Non-US</th>        
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th>Sex:</th>
        <td><?php echo checkbox_tag('send_filter[sex][]', 'M', null, array('class' => 'checkbox')) ?></td>
        <th>Men</th>
        <td><?php echo checkbox_tag('send_filter[sex][]', 'F', null, array('class' => 'checkbox')) ?></td>
        <th>Women</th>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th>Country:</th>
        <td><?php echo checkbox_tag('send_filter[filter_country]', 1, null, array('class' => 'checkbox')) ?></td>
        <td colspan="3" style="vertical-align: middle"><?php echo select_country_tag('send_filter[country]', null, array('include_custom' => 'All Countries')) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>        
      </tr>
      <tr>
        <th>Language</th>
        <td><?php echo checkbox_tag('send_filter[filter_language]', 1, null, array('class' => 'checkbox')) ?></td>
        <td colspan="3" style="vertical-align: middle"><?php echo select_language_tag('send_filter[language]', null, array('include_custom' => 'All Languages')) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>        
      </tr>
    <tbody>
  </table>
</fieldset>

<hr />

<fieldset class="form_fields email_fields">
  <label for="subject">Subject</label>
  <?php echo input_tag('subject', $sf_request->getParameter('subject', $template->getSubject())) ?><br />
  
  <label for="body">Body</label>
  <?php echo textarea_tag('message_body', Tools::br2nl($sf_request->getParameter('body', $template->getBody())), array('cols' => 90, 'rows' => 10)) ?><br />
  
  <label for="message_footer">Footer</label>
  <?php echo textarea_tag('message_footer', Tools::br2nl($sf_request->getParameter('message_footer', $template->getFooter())), array('cols' => 90, 'rows' => 5)) ?><br />
  
  <label for="save_as_new_template">Save as new template</label>
  <?php echo input_tag('save_as_new_template', null, 'id=save_as_new_template') ?><br />
</fieldset>

<fieldset class="actions">
  <?php echo button_to('Cancel', 'feedback/list') ?>
  <?php echo submit_tag('Save Draft', 'name=save_draft') ?>
  <?php echo submit_tag('Send', 'name=send') ?>
</fieldset>

</form>
