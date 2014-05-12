<?php include_partial('searchTypes'); ?>

<form action="<?php echo url_for('search/profileID')?>" method="post">
    <label for="profile_id"><?php echo __('Enter profile ID') ?></label>
    <?php echo input_tag('profile_id', null, array(
      'id' => 'profile_id',
      'class' => 'input_text_width'
    )); ?><br />
    <?php echo submit_tag(__('Search'), array('class' => 'button')) ?>
</form>

<br /><br />

<?php if (isset($pager) && $pager->getNbResults() > 0): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/mostRecent')); ?>
<?php elseif ($sf_request->getParameter('profile_id')): ?>
    <div class="msg_error text-center">
      <?php echo __('We could not find a member with the ID you specified,
        please make sure you have the right ID number or use another type of search') ?>
    </div>
<?php endif; ?>
