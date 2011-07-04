<?php use_helper('I18N'); ?>

<?php $context = sfContext::getInstance(); ?>

<?php if( $context->getActionName() != 'conversation'): ?>
    <?php if($sf_user->isAuthenticated()): ?>

      <?php echo form_tag($context->getModuleName() . '/' . $context->getActionName(), array('method' => 'get'));?>
        <?php echo input_hidden_tag('filter', 'filter'); ?>
        <?php echo input_hidden_tag('id', $sf_request->getParameter('id') ); ?>
        <ul id="left_menu">
  
        <?php foreach ($menu as $key => $item): ?>
          <?php if( $context->getModuleName() . '/' . $context->getActionName() == $item['uri'] || $left_menu_selected == $item['title'] || $left_menu_selected === $key+1): ?>
              <li class="selected"><?php echo $item['title'] ?></li>
          <?php else: ?>
            <li><?php echo link_to($item['title'], $item['uri']) ?></li>
          <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
        <li></li> <?php //blank li for HTML validation ?>
  
        <?php if( $left_menu_selected == 'Messages'): ?>
          <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
          <li>Stared:</li>
          <?php foreach($starred_array as $key => $value): ?>
          <li>
              <?php echo checkbox_tag('filters[starred][]', $key, @in_array($key, $filters['starred']) );?>
              <label><?php echo $value; ?></label>
          </li>
          <?php endforeach; ?>
          <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
          <li>&nbsp;</li>
        <?php endif; ?>
     
          </ul>
        </form>
<?php else: ?>
    <ul id="left_menu">
        <li></li>
    </ul>
<?php endif; ?>
