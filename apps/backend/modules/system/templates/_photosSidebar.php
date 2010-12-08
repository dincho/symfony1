<?php use_helper('I18N'); ?>

<?php if($sf_user->isAuthenticated()): ?>
  <?php $context = sfContext::getInstance(); ?>

  <?php echo form_tag($context->getModuleName() . '/' . $context->getActionName(), array('method' => 'get'));?>
    <?php echo input_hidden_tag('filter', 'filter'); ?>
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
  
      <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
      <li>Catalog:</li>
      <li>
        <?php echo select_tag('filters[cat_id]', options_for_select($catalogues, $sf_params->get('filters[cat_id]',0)));?>
      </li> 
      <li></li> 
     <li>Status:</li>
      <?php foreach($statuses as $status): ?>
      <li>
          <?php echo checkbox_tag('filters[status_id][]', $status->getId(), @in_array($status->getId(), $filters['status_id']) );?>
          <label><?php echo $status->getTitle(); ?></label>
      </li>
      <?php endforeach; ?>
      <li>&nbsp;</li>
              
      <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
      <li>&nbsp;</li>
      <?php if($sf_params->has('pending_verification')): ?>
        <?php echo input_hidden_tag('pending_verification', $sf_params->get('pending_verification')) ?>
      <?php endif; ?>
      <?php if($sf_params->has('filters[sex]')): ?>
        <?php echo input_hidden_tag('filters[sex]', $sf_params->get('filters[sex]')) ?>
      <?php endif; ?>
      <?php if($sf_params->has('filters[public_search]')): ?>
        <?php echo input_hidden_tag('filters[public_search]', $sf_params->get('filters[public_search]')) ?>
      <?php endif; ?>
      <?php if($sf_params->has('filters[by_country]')): ?>
        <?php echo input_hidden_tag('filters[by_country]', $sf_params->get('filters[by_country]')) ?>
      <?php endif; ?>
      <?php if($sf_params->has('filters[by_country]')): ?>
        <?php echo input_hidden_tag('filters[by_country]', $sf_params->get('filters[by_country]')) ?>
      <?php endif; ?>
      <?php if($sf_params->has('filters[country]')): ?>
        <?php echo input_hidden_tag('filters[country]', $sf_params->get('filters[country]')) ?>
      <?php endif; ?>
      
      </ul>
    </form>
