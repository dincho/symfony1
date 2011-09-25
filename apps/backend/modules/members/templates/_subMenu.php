<?php if( isset($class) ): ?>
<div id="sub_menu" class="<?php echo $class; ?>">
<?php else: ?>
<div id="sub_menu">
<?php endif; ?>
  <span class="sub_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to('Overview', 'members/edit?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Registration', 'members/editRegistration?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Self-Description', 'members/editSelfDescription?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Essay', 'members/editEssay?id=' . $member->getId(), $member->IsEssayInRed()?"class=red":"") ?>&nbsp;|</li>
    <li><?php echo link_to('Photos', 'members/editPhotos?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('IMBRA', 'members/editIMBRA?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Search Criteria', 'members/editSearchCriteria?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Status History', 'members/editStatusHistory?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Subscripion History', 'members/editSubscriptionHistory?id=' . $member->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to('Messages', 'messages/member?id=' . $member->getId());?>&nbsp;|</li>
    <li><?php echo link_to('Subscriptions', 'members/subscriptions?id=' . $member->getId());?>&nbsp;|</li>
    <li><?php echo link_to('Payments', 'members/payments?id=' . $member->getId());?>&nbsp;|</li>
    <li><?php echo link_to('Open Privacy', 'members/editOpenPrivacy?id=' . $member->getId() . '&received_only=' . $sf_request->getParameter('received_only')); ?></li>
  </ul>
</div>