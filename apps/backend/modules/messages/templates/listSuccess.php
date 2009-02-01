<?php echo use_helper('Javascript', 'Number', 'xSortableTitle') ?>
<?php echo form_tag('messages/list', array('method' => 'get', 'id' => 'search_filter')) ?>
    <div class="filter_right text-right">
        <?php echo input_date_tag('filters[date_from]', ( isset($filters['date_from']) ) ? $filters['date_from'] : time() - 2592000, array('calendar_button_img' => '/sf/sf_admin/images/date.png',
                                                              'format' => 'MM/dd/yy', 'rich' => true, 'readonly' => true, 'style' => 'width: 74px;', 'withtime' => false, 'class' => '', 'calendar_options' => 'button: "filters_date_from"')) ?> -
                                                               
        <?php echo input_date_tag('filters[date_to]', ( isset($filters['date_to']) ) ? $filters['date_to'] : time(), array('calendar_button_img' => '/sf/sf_admin/images/date.png',
                                                              'format' => 'MM/dd/yy', 'rich' => true, 'readonly' => true, 'style' => 'width: 74px;', 'withtime' => false, 'class' => '', 'calendar_options' => 'button: "filters_date_to"')) ?>
                                                              <br />
        Total: <?php echo format_number($pager->getNbResults()) ?>
    </div>

    <?php echo input_hidden_tag('filter', 'filter', 'class=hidden') ?>
    <fieldset class="search_fields">
        <label for="query">Search for:</label><br />
        <?php echo input_tag('filters[search_query]', ( isset($filters['search_query']) ) ? $filters['search_query'] : null) ?>    
    </fieldset>
    <fieldset class="search_fields">
        <label for="search_type">Search by:</label><br />
        <?php echo select_tag('filters[search_type]', options_for_select(array('username' => 'Username', 'first_name' => 'First Name', 'last_name' => 'Last Name'), ( isset($filters['search_type']) ) ? $filters['search_type'] : null)) ?>       
    </fieldset>
    <fieldset>
        <label for="search">&nbsp;</label><br />
        <?php echo submit_tag('Search', 'id=search') ?>       
    </fieldset>
</form>


<table class="zebra">
  <thead>
    <tr>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last name', 'Member::last_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('First name', 'Member::first_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
      <th><?php echo sortable_title('For', 'Member::looking_for', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last Activity', 'Member::last_activity', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sent To', 'Message::to_member_id', $sort_namespace) ?></th>      
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $message): ?>
  <?php $member = $message->getMemberRelatedByFromMemberId(); //shortcut ?>
  <tr rel="<?php echo url_for('messages/conversation?id=' . $message->getId()) ?>" onmouseover="preview_click('<?php echo $message->getId();?>')" onmouseout2="preview_clear();">
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId() ?></td>
    <td><?php echo $member->getLastName() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getLookingFor() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getLastActivity('m/d/Y') ?></td>
    <td><?php echo $message->getMemberRelatedByToMemberId()->getUsername() ?></td>
    <td class="profile_link"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
    <td class="preview_button">
        <?php echo button_to_remote('Preview', array('url' => 'ajax/getMessageById?id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'messages/list')); ?>
<div id="preview"></div>