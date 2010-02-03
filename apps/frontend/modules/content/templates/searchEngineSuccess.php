<?php use_helper('I18N');?>

<p>
    <?php echo __('This page provides links to all profiles listed in a format geared to search engine robots.') ?><br />
    <?php echo link_to(__('Click here to return to My Polish Love Home Page'), '@homepage'); ?><br /><br />
</p>

<?php foreach ($pager->getResults() as $member):?>
    <?php echo link_to($member->getEssayHeadline(), '@public_profile?username=' . $member->getUsername()) ?><br />
<?php endforeach;?>

<?php if( $pager->haveToPaginate() ): ?>
    <br /><?php echo link_to(__('[More]'), '@search_engines?page='.$pager->getNextPage());?><br /><br />
<?php endif; ?>

