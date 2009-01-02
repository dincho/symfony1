<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('imbra/approve', 'class=form') ?>
  <?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>
  <?php echo object_input_hidden_tag($imbra, 'getId', 'class=hidden') ?>
  
  <div class="legend">Username: <?php echo $member->getUsername(); ?></div>
  <fieldset class="form_fields float-left">
    <label style="text-align: left;">English Profile View</label><br />
    <?php $imbra_text_en = get_partial('imbra_text', array('member' => $member, 'imbra' => $imbra, 'culture' => 'en')); ?>
    <?php echo textarea_tag('text_en', $imbra_text_en, 'cols=75 rows=33') ?>
  </fieldset>
  
  <fieldset class="form_fields float-left">
    <label style="text-align: left;">Polish Profile View</label><br />
    <?php $imbra_text_pl = get_partial('imbra_text', array('member' => $member, 'imbra' => $imbra, 'culture' => 'pl')); ?>
    <?php echo textarea_tag('text_pl', $imbra_text_pl, 'cols=75 rows=33') ?>
  </fieldset><br />
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'imbra/edit?cancel=1&member_id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">History:</span>
  <ul>
    <?php foreach ($imbras as $imbra_history): ?>
    <li><?php echo link_to($imbra_history->getCreatedAt('m/d/Y'), 'imbra/approve?member_id=' . $member->getId() .'&id=' . $imbra_history->getId(). '&filters[imbra_status_id]=' . $filters['imbra_status_id']) ?>&nbsp;|&nbsp;</li>
    <?php endforeach; ?>
  </ul>
</div>