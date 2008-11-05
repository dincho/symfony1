<table class="zebra">
<thead>
  <tr>
    <th>Self-Description Title</th>
    <th>Profile Page Title</th>
    <th>Search Criteria Title</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($questions as $question): ?>
  <tr rel="<?php echo url_for('descAnswers/list?question_id=' . $question->getId()) ?>" >
    <td><?php echo $question->getTitle(); ?></td>
    <td><?php echo $question->getDescTitle(); ?></td>
    <td><?php echo $question->getSearchTitle(); ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

