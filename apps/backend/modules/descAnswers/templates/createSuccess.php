<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('descAnswers/create', 'class=form') ?>
  <?php echo input_hidden_tag('question_id', $question->getId(), 'class=hidden') ?>
  <div class="legend">New Answer</div>
  <fieldset class="form_fields">

    <label for="title">Title:</label>
    <?php echo input_tag('title', null, error_class('title')) ?><br />

    <label for="search_title">Search Title:</label>
    <?php echo input_tag('search_title', null, error_class('search_title')) ?><br />

  </fieldset>
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'descAnswers/list?cancel=1&question_id=' . $question->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
