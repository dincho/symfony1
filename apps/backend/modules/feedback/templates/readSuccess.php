<?php use_helper('Javascript', 'Date') ?>

<div class="legend">Email from <?php echo $message->getFrom() ?></div>
<div id="container">
    <table class="details">
        <tr>
            <th>From Email</th>
            <td><?php echo $message->getMailFrom() ?></td>
        </tr>
        <?php if( $message->getMemberId()): ?>
        <tr>
            <th>Username</th>
            <td><?php echo $message->getMember()->getUsername() ?></td>
            <td><?php echo link_to('view FE profile', $message->getMember()->getFrontendProfileUrl(), array('popup' => true)) ?></td>

        </tr>
        <tr>
            <th>Profile ID</th>
            <td><?php echo $message->getMember()->getId() ?></td>
            <td><?php echo link_to('edit BE profile', 'members/edit?id=' . $message->getMember()->getId(), array('popup' => true)) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th>Subject</th>
            <td><?php echo strip_tags($message->getSubject()) ?></td>
        </tr>
        <tr>
            <th>To</th>
            <td><?php echo $message->getTo() ?></td>
        </tr>
        <tr>
            <th>Received</th>
            <td><?php echo time_ago_in_words($message->getCreatedAt(null)) ?></td>
        </tr>
        
    </table>
    <hr />
    <p><?php echo nl2br(strip_tags($message->getBody(), '<br><strong>')) ?></p>
</div>

<fieldset class="actions">
  <?php echo button_to_function('Close', 'history.go(-1)') ?>
  <?php echo button_to('Delete', 'feedback/delete?marked[]=' . $message->getId()) ?>
  <?php echo button_to('Reply', 'feedback/reply?id=' . $message->getId()) ?>
  <?php echo button_to('Edit As New', 'feedback/open?id=' . $message->getId()) ?>
  <?php echo button_to('Add to BugTrac', 'feedback/addToBugTrac?id=' . $message->getId(), 'confirm=Did you confirmed this bug and collected all details already?') ?>
</fieldset>