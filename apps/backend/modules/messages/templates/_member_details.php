<div class="legend"><?php echo $member->getUsername(); ?></div>

<div id="inner_content">
    <table class="details">
        <tbody>
          <tr>
            <th>Username</th>
            <td><?php echo $member->getUsername(); ?></td>
            <th>Sent Messages</th>
            <td><?php echo $member->getCounter('SentMessages') ?></td>
            <td vertical-align="top"><?php echo link_to('view profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
          </tr>
          <tr>
            <th>First Name</th>
            <td><?php echo $member->getFirstName(); ?></td>
            <th>Received Messages</th>
            <td colspan="2"><?php echo $member->getCounter('ReceivedMessages') ?></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?php echo $member->getLastName(); ?></td>
            <th>Sent Winks</th>
            <td colspan="2"><?php echo $member->getCounter('SentWinks') ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo $member->getEmail(); ?></td>
            <th>Received Winks</th>
            <td colspan="2"><?php echo $member->getCounter('ReceivedWinks') ?></td>
          </tr>
          <tr>
            <th>Profile ID</th>
            <td><?php echo $member->getId() ?></td>
            <th>On Others Hotlist</th>
            <td colspan="2"><?php echo $member->getCounter('OnOthersHotlist') ?></td>
          </tr>
          <tr>
            <th>Member Since</th>
            <td><?php echo $member->getCreatedAt('M d, Y') ?></td>
            <th>Members on Hotlist</th>
            <td colspan="2"><?php echo $member->getCounter('Hotlist') ?></td>  
          </tr>
        <tbody>
    </table>
</div>
<div id="bottom_menu">
  <span class="bottom_menu_title">View:</span>
  <ul>
    <li><?php echo link_to_unless(!$sf_request->getParameter('received_only'), 'Sent', 'messages/member?received_only=0&id=' . $member->getId()) ?></li>
    <li><?php echo link_to_unless($sf_request->getParameter('received_only'), 'Received', 'messages/member?received_only=1&id=' . $member->getId()) ?></li>
  </ul>
</div>

<br />
