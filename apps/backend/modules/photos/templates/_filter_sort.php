<?php echo link_to_unless($sf_user->getAttribute('sort', null, $sort_namespace) == 'Member::created_at' && $sf_context->getActionName() != 'stockPhotos', 'Most Recent', 'photos/list?sort=Member::created_at&type=desc&filter=filter') ?>&nbsp;|&nbsp;
<?php echo link_to_unless(isset($filters['sex']) &&  $filters['sex'] == 'M', 'Male', 'photos/list?filter=filter&filters[sex]=M&sort=no') ?>&nbsp;|&nbsp;
<?php echo link_to_unless(isset($filters['sex']) &&  $filters['sex'] == 'F', 'Female', 'photos/list?filter=filter&filters[sex]=F&sort=no') ?>&nbsp;|&nbsp;
<?php echo link_to_unless(isset($filters['by_country']) && $filters['by_country'] == 1, 'Country', 'photos/list?filter=filter&filters[by_country]=1&sort=no') ?>
<?php if( isset($filters['by_country']) && $filters['by_country'] == 1 && isset($filters['country'])): ?>
    (<?php echo link_to($filters['country'], 'photos/selectCountryFilter') ?>)
<?php endif; ?>
&nbsp;|&nbsp;
<?php echo link_to_unless($sf_user->getAttribute('sort', null, $sort_namespace) == 'MemberCounter::profile_views', 'Popularity', 'photos/list?sort=MemberCounter::profile_views&type=desc&filter=filter') ?>&nbsp;|&nbsp;
<?php echo link_to_unless($sf_context->getActionName() == 'stockPhotos' && $sf_request->getParameter('only') == 2, 'Home Page', 'photos/stockPhotos?sort=no&filter=filter&only=2') ?>&nbsp;|&nbsp;
<?php echo link_to_unless($sf_context->getActionName() == 'stockPhotos' && $sf_request->getParameter('only') == 1, 'Member Stories', 'photos/stockPhotos?sort=no&filter=filter&only=1') ?>&nbsp;|&nbsp;
<?php echo link_to_unless(isset($filters['public_search']) &&  $filters['public_search'] == 1, 'Public Search', 'photos/list?filter=filter&filters[public_search]=1&sort=no') ?>&nbsp;|&nbsp;
<?php echo link_to_unless($sf_context->getActionName() =='stockPhotos' && !$sf_request->getParameter('only'), 'Stock Photos', 'photos/stockPhotos') ?>&nbsp;|&nbsp;
<?php echo link_to_unless(count($filters) < 1 && is_null($sf_user->getAttribute('sort', null, $sort_namespace)) && $sf_context->getActionName() != 'stockPhotos', 'All', 'photos/list?filter=filter&sort=no') ?>

