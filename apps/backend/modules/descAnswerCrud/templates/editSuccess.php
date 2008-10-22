<?php
// auto-generated by sfPropelCrud
// date: 2008/08/01 09:57:51
?>
<?php use_helper('Object') ?>

<?php echo form_tag('descAnswerCrud/update') ?>

<?php echo object_input_hidden_tag($desc_answer, 'getId') ?>

<table>
<tbody>
<tr>
  <th>Desc question*:</th>
  <td><?php echo object_select_tag($desc_answer, 'getDescQuestionId', array (
  'related_class' => 'DescQuestion',
)) ?></td>
</tr>
<tr>
  <th>Title:</th>
  <td><?php echo object_input_tag($desc_answer, 'getTitle', array (
  'size' => 80,
)) ?></td>
</tr>
<tr>
  <th>Search title:</th>
  <td><?php echo object_input_tag($desc_answer, 'getSearchTitle', array (
  'size' => 80,
)) ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($desc_answer->getId()): ?>
  &nbsp;<?php echo link_to('delete', 'descAnswerCrud/delete?id='.$desc_answer->getId(), 'post=true&confirm=Are you sure?') ?>
  &nbsp;<?php echo link_to('cancel', 'descAnswerCrud/show?id='.$desc_answer->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'descAnswerCrud/list') ?>
<?php endif; ?>

</form>
