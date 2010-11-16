<?php use_helper('Javascript') ?>

<div class="legend">Email from <?php echo $message->getSender() ?></div>
<div id="container">
    <table class="details">
        <tr>
            <th>From Email</th>
            <td><?php echo $message->getMailFrom() ?></td>
        </tr>
        <tr>
            <th>Subject</th>
            <td><?php echo strip_tags($message->getSubject()) ?></td>
        </tr>
        <tr>
            <th>To</th>
            <td><?php echo implode ( ', ', $message->getRecipients()) ?></td>
        </tr>
        
    </table>
    <hr />
    <p><?php echo nl2br(strip_tags($message->getBody(), '<br><strong>')) ?></p>
</div>

<fieldset class="actions">
  <?php echo button_to_function('Close', 'history.go(-1)') ?>
</fieldset>