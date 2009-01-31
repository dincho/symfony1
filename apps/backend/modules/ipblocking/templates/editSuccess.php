<?php use_helper('Object', 'dtForm', 'Javascript', 'General') ?>
<?php include_component('system', 'formErrors') ?>


<?php echo form_tag('ipblocking/add', 'class=form') ?>
    <div class="legend">Edit IP Block</div>
      <fieldset class="form_fields float-left">
        <label for="item">Item:</label>
        <?php echo object_input_tag($ipblock, 'getItem', error_class('item')) ?>
        
	<span id="netmask_container" style="display: visible;">
        <label for="netmask" style="width: 1em;">/</label>
        <?php echo object_input_tag($ipblock, 'getNetmask', error_class('netmask').' size=2 style="width: 2em;"') ?>Netmask
	</span>
    <br /> 
        
        <label for="title">Item Type:</label>
        <?php echo block_item_type('item_type', $ipblock->getItemType(), error_class('item_type') ) ?><br /> 
          
       
      </fieldset>
  



  <fieldset class="actions">
    <?php echo button_to('Cancel', 'ipblocking/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php echo javascript_tag("updatenetmask()");?>
