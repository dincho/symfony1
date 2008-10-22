<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('transUnits/create', 'class=form') ?>
  <div class="legend">Creating Translation Unit</div>
  <fieldset class="form_fields">
    
    <label for="catalogue">Catalogue:</label>
    <?php echo object_select_tag(null, 'getCatId', 
               array ('related_class' => 'Catalogue',
                      'peer_class' => 'CataloguePeer'
    )) ?><br />
  
  <label for="source">Source:</label>
  <?php echo textarea_tag('source', null, array ('size' => '60x5')) ?><br />
  <label for="target">Target:</label>
  <?php echo textarea_tag('target', null, array ('size' => '60x5')) ?><br />
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'transUnits/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

