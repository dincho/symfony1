<?php use_helper('Javascript', 'dtBoolValue') ?>

<table class="zebra">
    <thead>
        <tr>
            <th>Name</th>
            <?php if( !$sf_request->getParameter('to_admins') ): ?>
              <th>Language</th>
            <?php endif; ?>
            <th>Status</th>
        </tr>
    </thead>
    
<?php foreach ($notifications as $notification): ?>
    <?php if( $sf_request->getParameter('to_admins') ): ?>
      <tr rel="<?php echo url_for('notifications/edit?id=' . $notification->getId()) ?>">
    <?php else: ?>
      <tr>
    <?php endif; ?>
        <td><?php echo $notification->getName(); ?></td>
        <?php if( !$sf_request->getParameter('to_admins') ): ?>
        <td>
          <?php echo link_to(image_tag('flags/us.gif'), 'notifications/edit?culture=en&id=' . $notification->getId()) ?>
          <?php echo link_to(image_tag('flags/pl.gif'), 'notifications/edit?culture=pl&id=' . $notification->getId()) ?>
        </td>
        <?php endif; ?>
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