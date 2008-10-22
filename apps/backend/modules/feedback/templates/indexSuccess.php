<table>
  <tr>
    <th>Subject</th>
    <th>To</th>
  </tr>
<?php foreach ($messages as $message): ?>
  <tr>
    <td><?php echo $message->getHeader('Subject') ?></td>
    <td><?php $a =  $message->getTo(); echo $a['email']?></td>
  </tr>
<?php endforeach; ?>
</table>