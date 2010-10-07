<?php use_helper('Javascript', 'dtBoolValue', 'Number') ?>

<table class="zebra">
    <thead>
        <tr>
            <th>Name</th>
            <th>Mail Config</th>
            <th>Today</th>
            <th>Status</th>
        </tr>
    </thead>
    
<?php foreach ($notifications as $notification): ?>
      <tr rel="<?php echo url_for('notifications/edit?id=' . $notification->getId() . '&cat_id=' . $sf_request->getParameter('cat_id')) ?>">
        <td><?php echo $notification->getName(); ?></td>
        <td><?php echo $notification->getMailConfig(); ?></td>
        <td><?php echo format_number($notification->getToday()); ?></td>
        <td><?php echo boolValue($notification->getIsActive(), 'On', 'Off'); ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php include_component('content', 'bottomMenu', array('url' => 'notifications/list?to_admins=' . $sf_request->getParameter('to_admins'))); ?><br />

<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless(!$sf_request->getParameter('to_admins'), 'To Members', 'notifications/list?to_admins=0&cat_id=' . $sf_request->getParameter('cat_id')) ?>&nbsp;|&nbsp;</li>
    <li><?php echo link_to_unless($sf_request->getParameter('to_admins'),'To Admin Users', 'notifications/list?to_admins=1&cat_id=' . $sf_request->getParameter('cat_id')) ?></li>
  </ul>
</div>