<?php use_helper('Javascript', 'dtBoolValue') ?>

<table class="zebra">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
        </tr>
    </thead>
    
<?php foreach ($notifications as $notification): ?>
    <tr rel="<?php echo url_for('notifications/edit?id=' . $notification->getId()) ?>">
        <td><?php echo $notification->getName(); ?></td>
        <td><?php echo boolValue($notification->getIsActive(), 'On', 'Off'); ?></td>
    </tr>
<?php endforeach; ?>
</table>

<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless(!$sf_request->getParameter('to_admins'), 'To Members', 'notifications/list?to_admins=0') ?>&nbsp;|&nbsp;</li>
    <li><?php echo link_to_unless($sf_request->getParameter('to_admins'),'To Admin Users', 'notifications/list?to_admins=1') ?></li>
  </ul>
</div>