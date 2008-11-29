<?php use_helper('Object', 'dtForm', 'I18N', 'Javascript') ?>

<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('flagCategories/edit', 'class=form') ?>
  <div class="legend">Flag Categories</div>
  <fieldset class="form_fields" id="states_fieldset">
    
    <label for="title">Categires:</label><br />
    <?php foreach ($categories as $category): ?>
        <label>&nbsp;</label>
        <?php echo object_input_tag($category, 'getTitle', array('class' => error_class('title', true), 'control_name' => 'categories[' . $category->getId() . ']') ) ?><br />
    <?php endforeach; ?>
    
    <label>&nbsp;</label>
    <?php echo link_to_function('+Add', 'add_form_field(this.parentNode, "categories[]") ', array('style' => 'float: left')) ?><br />
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'flagCategories/edit?confirm_msg=' . confirmMessageFilter::CANCEL)  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
