<?php use_helper('I18N');?>

<p>
    <?php echo __('This page provides links to all profiles listed in a format geared to search engine robots.') ?><br />
    <?php echo __('Click here to return to My Polish Love Home Page'); ?><br /><br />
</p>

<?php foreach ($pager->getResults() as $member):?>
    <?php echo link_to($member->getEssayHeadline(), '@profilese?username=' . $member->getUsername() . '&headline=' . Tools::slugify($member->getEssayHeadline(ESC_RAW))) ?><br />
<?php endforeach;?>

<?php if( $pager->haveToPaginate() ): ?>
    <br /><?php echo link_to(__('[More]'), '@search_engines?page='.$pager->getNextPage());?><br /><br />
<?php endif; ?>

