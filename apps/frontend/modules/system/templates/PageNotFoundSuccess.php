<?php slot('header_title') ?>
    <?php echo __('Oops, Page Not Found') ?>
<?php end_slot(); ?>

<?php echo __('Sorry, we could not find the page you are looking for.'); ?><br /><br />
<?php echo __('If you\'re a member, please go to your ') . link_to(__('dashboard.'), 'dashboard/index', array('class' => 'sec_link')); ?><br /><br />
<?php echo __('If you\'re not a member, please ') . link_to(__('sign up for free now'), '#') . __(' or ') . link_to(__('go to home page.'), '@homepage',  array('class' => 'sec_link'));?>