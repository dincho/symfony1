<?php
// auto-generated by sfPropelCrud
// date: 2008/08/01 09:57:51
?>
<h1>descAnswerCrud</h1>

<table>
<thead>
<tr>
  <th>Id</th>
  <th>Desc question</th>
  <th>Title</th>
  <th>Search title</th>
</tr>
</thead>
<tbody>
<?php foreach ($desc_answers as $desc_answer): ?>
<tr>
    <td><?php echo link_to($desc_answer->getId(), 'descAnswerCrud/edit?id='.$desc_answer->getId()) ?></td>
      <td><?php echo link_to($desc_answer->getDescQuestion(), 'descAnswerCrud/edit?id='.$desc_answer->getId()) ?></td>
      <td><?php echo link_to($desc_answer->getTitle(), 'descAnswerCrud/edit?id='.$desc_answer->getId()) ?></td>
      <td><?php echo link_to($desc_answer->getSearchTitle(), 'descAnswerCrud/edit?id='.$desc_answer->getId()) ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo link_to ('create', 'descAnswerCrud/create') ?>
