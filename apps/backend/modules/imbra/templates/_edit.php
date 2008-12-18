<?php use_helper('Javascript') ?>
<?php if( $imbra ): ?>
    <div id="inner_content">
      
      <div class="imbra_alert float-right">
        <?php if( $imbra->isPossibleDenial()): ?>
          <p>Possible Denial</p>
        <?php endif; ?>
       <p>Days in: <?php echo $imbra->getDaysIn(); ?></p>
      </div>
      
      <table class="details">
        <tbody>
          <tr>
            <th>Username</th>
            <td><?php echo $member->getUsername() . link_to('&nbsp;&nbsp;view profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
            <th>Profile ID</th>
            <td><?php echo $member->getId(); ?></td>
          </tr>
          <tr>
            <th>First Name</th>
            <td><?php echo $member->getFirstName(); ?></td>
            <th>Member Since</th>
            <td><?php echo $member->getCreatedAt('M d, Y') ?></td>
          </tr>
          <tr>
            <th>Last Name</th>
            <td><?php echo $member->getLastName(); ?></td>
            <th>Current Flags</th>
            <td><?php echo $member->getCounter('CurrentFlags'); ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo $member->getEmail(); ?></td>
            <th>Total Flags</th>
            <td><?php echo $member->getCounter('TotalFlags'); ?></td>
          </tr>
          <tr>
            <th>Subscription</th>
            <td>free</td>
            <th>Un-Suspended</th>
            <td><?php echo $member->getCounter('Unsuspensions'); ?></td>
          </tr>
          <tr>
            <th>Status</th>
            <td><?php echo $member->getMemberStatus(); ?></td>
            <th>Reviewed</th>
            <td><?php echo ($member->getReviewedAt()) ? $member->getReviewedBy() . '&nbsp;' . $member->getReviewedAt('m/d/Y') : 'No' ?></td>      
          </tr>
        <tbody>
      </table>
      
      <dl class="imbra_answers">
        <?php foreach ($imbra->getMemberImbraAnswers() as $answer): ?>
          <dt><?php echo $answer->getImbraQuestion()->getTitle(); ?></dt>
          <dd><?php echo  $answer->getAnswerString() ?></dd>
        <?php endforeach; ?>
      </dl>
    </div>
    <div class="actions">
      <?php echo button_to_function('Close', 'history.go(-1)') ?>
      <?php echo button_to('Deny', 'imbra/deny?member_id=' . $member->getId() . '&id=' . $imbra->getId()) ?>
      <?php echo button_to('Approve', 'imbra/approve?member_id=' . $member->getId() . '&id=' . $imbra->getId()) ?>
    </div>
<?php else: ?>
    <p>This member have no IMBRA application yet.</p>
<?php endif; ?>
