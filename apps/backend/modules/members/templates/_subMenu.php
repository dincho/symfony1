<?php if( isset($class) ): ?>
<div id="sub_menu" class="<?php echo $class; ?>">
<?php else: ?>
<div id="sub_menu">
<?php endif; ?>
  <span class="sub_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to('Overview', 'members/edit?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Registration', 'members/editRegistration?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Self-Description', 'members/editSelfDescription?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Essay', 'members/editEssay?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Photos', 'members/editPhotos?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('IMBRA', 'members/editIMBRA?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Search Criteria', 'members/editSearchCriteria?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Status History', 'members/editStatusHistory?id=' . $member_id) ?>&nbsp;|</li>
    <li><?php echo link_to('Messages', 'messages/member?id=' . $member_id);?>&nbsp;|</li>
    <li><?php echo link_to('Subscriptions', 'members/subscriptions?id=' . $member_id);?>&nbsp;|</li>
    <li><?php echo link_to('Payments', 'members/payments?id=' . $member_id);?></li>
  </ul>
</div>