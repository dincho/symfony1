<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('descAnswers/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($answer, 'getId', 'class=hidden') ?>
  <div class="legend">Editing Answer</div>
  <fieldset class="form_fields">
    
    <label for="title">Title:</label>
    <?php echo object_input_tag($answer, 'getTitle', error_class('title')) ?><br />
    
    <label for="search_title">Search Title:</label>
    <?php echo object_input_tag($answer, 'getSearchTitle', error_class('search_title')) ?><br />
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'descAnswers/list?cancel=1&question_id=' . $question->getId())
          . button_to('Delete', 'descAnswers/delete?&id=' . $answer->getId(), 'confirm=Are you sure you want to delete this answer?')
          . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
