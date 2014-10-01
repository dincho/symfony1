<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('memberStories/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($story, 'getId', 'class=hidden') ?>
  <div class="legend">Edit <?php echo $story->getSlug() ?>.html</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <div style=float:left;"><?php echo object_input_tag($story, 'getLinkName', array('class'=> 'member_stories', error_class('link_name'))) ?></div><br />

        <label for="culture">Language:</label>
        <?php echo object_select_tag($story, 'getCatId', array ('related_class' => 'Catalogue','include_blank' => false,)); ?><br />

      </fieldset>
      <fieldset class="form_fields float-left">

        <label for="title">Title:</label>
        <?php echo object_input_tag($story, 'getTitle', array('class'=> 'member_stories', error_class('title'))) ?><br />

        <label for="keywords">Keywords:</label>
        <?php echo object_input_tag($story, 'getKeywords', array('class'=> 'member_stories', error_class('keywords'))) ?><br />

        <label for="description">Description:</label>
        <?php echo object_input_tag($story, 'getDescription', array('class'=> 'member_stories', error_class('description'))) ?><br />

        <label for="summary">Summary:</label>
        <?php echo object_input_tag($story, 'getSummary', array('class'=> 'member_stories', error_class('summary'))) ?><br />

      </fieldset>

  <fieldset class="form_fields email_fields" style="margin-top: 150px;">
    <label for="html_content">HTML Content:</label>
   <div style=float:left;"> <?php echo textarea_tag('html_content', $story->getContent(), 'rows=20 cols=38 id=html_content ' . error_class('html_content')) ?>
   </div>
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'memberStories/list?cancel=1&cat_id=' . $story->getCatId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
