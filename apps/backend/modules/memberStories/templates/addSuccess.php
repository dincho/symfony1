<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('memberStories/add', 'class=form') ?>
    <div class="legend">New Story</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <?php echo input_tag('link_name', null, error_class('link_name')) ?><br />

        <label for="catalog">Catalogue:</label>
        <?php echo  select_tag('cat_id', objects_for_select($catalogs, 'getCatId', '__toString')); ?><br />

      </fieldset>
      <fieldset class="form_fields float-left">

        <label for="title">Title:</label>
        <?php echo input_tag('title', null, error_class('title')) ?><br />

        <label for="keywords">Keywords:</label>
        <?php echo input_tag('keywords', null, error_class('keywords')) ?><br />

        <label for="description">Description:</label>
        <?php echo input_tag('description', null, error_class('description')) ?><br />

        <label for="summary">Summary:</label>
        <?php echo input_tag('summary', null, error_class('summary')) ?><br />

      </fieldset>

  <fieldset class="form_fields email_fields">
    <label for="html_content">HTML Content:</label>
    <?php echo textarea_tag('html_content', null, 'rows=20 cols=38 id=html_content ' . error_class('html_content')) ?>
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'memberStories/list?cancel=1&cat_id=' .$sf_request->getParameter('cat_id'))  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
