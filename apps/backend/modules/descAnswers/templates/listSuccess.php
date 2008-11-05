<table class="zebra">
<thead>
  <tr class="top_actions">
    <td colspan="2"><?php echo button_to ('Add Answer', 'descAnswers/create?question_id=' . $question->getId()) ?></td>
  </tr>
  <tr>
    <th>Title</th>
    <th>Search Criteria Title</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($answers as $answer): ?>
  <tr rel="<?php echo url_for('descAnswers/edit?id=' . $answer->getId()) ?>" >
    <td><?php echo $answer->getTitle(); ?></td>
    <td><?php echo $answer->getSearchTitle(); ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

