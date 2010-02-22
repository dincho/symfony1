<?php use_helper('Object', 'dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('content/homepage', 'class=form') ?>
  <?php echo input_hidden_tag('culture', $culture, 'class=hidden') ?>
  <div class="legend">Edit Home Page</div>

      <fieldset class="form_fields">
        <label for="culture">Language</label>
        <var><?php echo format_language($culture) ?></var><br />
        
        <label for="title">Title:</label>
        <?php echo input_tag('trans[3]', (isset($trans[3])) ? $trans[3]->getTarget() : null, error_class('title')) ?><br /> 
          
        <label for="keywords">Keywords:</label>
        <?php echo input_tag('trans[4]', (isset($trans[4])) ? $trans[4]->getTarget() : null, error_class('keywords')) ?><br />
        
        <label for="description">Description:</label>
        <?php echo textarea_tag('trans[5]', (isset($trans[5])) ? $trans[5]->getTarget() : null, 'cols=26 rows=2 ' . error_class('description')) ?><br />
      </fieldset>

      
      <fieldset class="form_fields float-left" style="margin-right: 45px">
        <label for="tagline">Tagline</label>
        <?php echo textarea_tag('trans[1]', (isset($trans[1])) ? $trans[1]->getTarget() : null, array('cols' => 40, 'rows' => 2)) ?><br />
        
        <label for="introduction">Introduction</label>
        <?php echo textarea_tag('trans[2]', (isset($trans[2])) ? $trans[2]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />
        
        <label for="right_introduction">Right Introduction</label>
        <?php echo textarea_tag('trans[149]', (isset($trans[149])) ? $trans[149]->getTarget() : null, array('cols' => 40, 'rows' => 5)) ?><br />        
      </fieldset>
        
  
      <fieldset class="form_fields">
        <label>Member Stories</label>
        <?php echo select_tag('member_stories', objects_for_select($member_stories, 'getId', 'getTitle', $homepage_stories), array('multiple' => true, 'style' => 'width: 350px; height: 200px')) ?>
      </fieldset><br style="clear: none;" /><br style="clear: none;" /><br style="clear: none;" /><br style="clear: none;" />

      
      <fieldset class="form_fields">
        <label for="footer_articles">Footer Articles:</label>
        <?php echo textarea_tag('trans[148]', (isset($trans[148])) ? $trans[148]->getTarget() : null, 'cols=120 rows=28 ' . error_class('footer_articles')) ?><br />
      </fieldset>        

  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'content/homepages?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
