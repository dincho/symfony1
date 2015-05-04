<label for="first_name">First Name</label>
<?php echo object_input_tag($member, 'getFirstName', error_class('first_name')) ?><br />

<label for="last_name">Last Name</label>
<?php echo object_input_tag($member, 'getLastName', error_class('last_name')) ?><br />

<label for="email">Email</label>
<?php echo object_input_tag($member, 'getEmail', error_class('email')) ?>
<?php if( !$member->getHasEmailConfirmation() ): ?>
  <?php echo link_to('Confirm', 'members/confirmEmail?id=' . $member->getId()); ?>&nbsp;|
<?php endif; ?>
<?php echo link_to('G Search', 'http://google.com/search',
                                    array( 'query_string' => 'q=' . urlencode($member->getEmail()),
                                           'target' => '_blank')); ?>
<br />
<?php if( !$member->getHasEmailConfirmation() ): ?>
    <label></label>
    <?php echo link_to('Re-send activation email', 'members/resendActivationEmail?id=' . $member->getId()); ?><br />
<?php endif; ?>

<label for="subscription_id">Subscription</label>
<?php echo object_select_tag($member, 'getSubscriptionId') ?><br />

<label for="member_status_id">Status</label>
<?php echo object_select_tag($member, 'getMemberStatusId', array ('related_class' => 'MemberStatus','include_blank' => false,)) ?><br />

<label for="orientation">Orientation</label>
<?php echo select_tag('orientation', looking_for_options_admin($member->getSex(), $member->getLookingFor())) ?><br />

<label for="catalog">Catalog</label>
<?php echo object_select_tag($member, 'getCatalogId', array('related_class' => 'Catalogue')) ?><br />

<label for="member_id">ID</label>
<var id="member_id"><?php echo $member->getId() ?></var><br />

<label for="created_at">Member Since</label>
<var id="created_at"><?php echo $member->getCreatedAt('M d, Y') ?></var><br />

<label for="last_visit">Last Visit</label>
<var id="last_visit"><?php echo $member->isLoggedIn()? 'Currently Online' :  (is_null($member->getLastLogin(null))?'never': time_ago_in_words($member->getLastLogin(null))) ?></var><br />

<label for="current_flags">Current Flags</label>
<var id="current_flags"><?php echo $member->getCounter('CurrentFlags'); ?></var><br />

<label for="total_flags">Total Flags</label>
<var id="total_flags"><?php echo $member->getCounter('TotalFlags') ?></var><br />

<label for="unsuspended">Un-suspended</label>
<var id="unsuspended"><?php echo $member->getCounter('Unsuspensions') ?></var><br />

<label for="reviewed">Reviewed</label>
<var id="reviewed"><?php if($member->getReviewedById() ) echo $member->getReviewedBy() . '&nbsp;' . $member->getReviewedAt('m/d/Y')?></var><br />

<label for="member_original_first_name">Orig. 1st Name</label>
<var id="member_original_first_name"><?php echo $member->getOriginalFirstName() ?></var><br />

<label for="member_original_last_name">Orig. Lst Name</label>
<var id="member_original_last_name"><?php echo $member->getOriginalLastName() ?></var><br />

<label for="member_private_dating">Private Dating</label>
<?php echo select_tag('private_dating', options_for_select(array("0" => 'off', "1" => 'ON'), ($member->getPrivateDating()) ? '1' : '0')) ?><br />

<label for="member_only_full">Only VIP</label>
<var id="member_only_full"><?php echo ($member->getContactOnlyFullMembers()) ? 'ON' : 'off'; ?></var><br />

<label for="member_hide_visits">Hide visits</label>
<var id="member_hide_visits"><?php echo ($member->getHideVisits()) ? 'ON' : 'off'; ?></var><br />

<?php include_component('members', 'MemberIpBlock',
    array('label' => "Registration IP", 'ip' => $member->getRegistrationIP())); ?>

<?php include_component('members', 'MemberIpBlock',
    array('label' => "Last IP", 'ip' => $member->getLastIP())); ?>
