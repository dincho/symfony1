<table class="zebra">
<thead>
  <tr class="top_actions">
    <td colspan="3"><?php echo button_to ('Add Answer', 'descAnswers/create?question_id=' . $question->getId()) ?></td>
  </tr>
  <tr>
    <th>Title</th>
    <th>Search Criteria Title</th>
    <th></th>
  </tr>
</thead>
<tbody>
  <?php foreach ($answers as $answer): ?>
  <tr rel="<?php echo url_for('descAnswers/edit?id=' . $answer->getId()) ?>" >
    <td><?php echo $answer->getTitle(); ?></td>
    <td><?php echo $answer->getSearchTitle(); ?></td>
    <td class="delete"><?php echo link_to('Delete', 'descAnswers/delete?id=' . $answer->getId(), 'confirm=Are you sure you want to delete this answer?') ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

