<div class="legend"><?php echo $member->getUsername(); ?></div>

<div id="inner_content">
    <table class="details">
        <tbody>
          <tr>
            <th>Username</th>
            <td><?php echo $member->getUsername(); ?></td>
            <th>Sent Messages</th>
            <td><?php echo $member->getCounter('SentMessages') ?></td>
          </tr>
          <tr>
            <th>First Name</th>
            <td><?php echo $member->getFirstName(); ?></td>
            <th>Received Messages</th>
            <td><?php echo $member->getCounter('ReceivedMessages') ?></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?php echo $member->getLastName(); ?></td>
            <th>Sent Winks</th>
            <td><?php echo $member->getCounter('SentWinks') ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo $member->getEmail(); ?></td>
            <th>Received Winks</th>
            <td><?php echo $member->getCounter('ReceivedWinks') ?></td>
          </tr>
          <tr>
            <th>Profile ID</th>
            <td><?php echo $member->getId() ?></td>
            <th>On Others Hotlist</th>
            <td><?php echo $member->getCounter('OnOthersHotlist') ?></td>
          </tr>
          <tr>
            <th>Member Since</th>
            <td><?php echo $member->getCreatedAt('M d, Y') ?></td>
            <th>Members on Hotlist</th>
            <td><?php echo $member->getCounter('Hotlist') ?></td>      
          </tr>
        <tbody>
    </table>
</div>
<div id="bottom_menu">
  <span>View:</span>
  <ul>
      <?php if( $sf_request->getParameter('received_only') ): ?>
        <li><?php echo link_to('Sent', 'messages/member?id=' . $member->getId()) ?></li>
        <li>Received</li>      
      <?php else: ?>
        <li>Sent</li>
        <li><?php echo link_to('Received', 'messages/member?received_only=1&id=' . $member->getId()) ?></li>      
      <?php endif; ?>
  </ul>
</div>

<br />
