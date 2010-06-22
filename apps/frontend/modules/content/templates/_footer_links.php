<?php $links_map = StaticPagePeer::getLinskMap($sf_user->getCatalogId()); ?>
<?php if($sf_context->getModuleName() != 'registration'): ?>
    <?php if( !$sf_user->isAuthenticated() ): ?>
        <?php echo link_to(__('Join Now'), 'registration/joinNow'); ?>&nbsp;&nbsp;&bull;&nbsp;
        <?php if(array_key_exists('how_it_works', $links_map)) echo link_to($links_map['how_it_works'], '@page?slug=how_it_works') . '&nbsp;&nbsp;&bull;&nbsp;' ?>
        <?php if(array_key_exists('about_us', $links_map)) echo link_to($links_map['about_us'], '@page?slug=about_us') . '&nbsp;&nbsp;&bull;&nbsp;' ?>
        <?php if(array_key_exists('help', $links_map)) echo link_to($links_map['help'], '@page?slug=help') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
        <?php if(array_key_exists('search_engines', $links_map)) echo link_to($links_map['search_engines'], '@search_engines' ) . '&nbsp;&nbsp;&bull;&nbsp;' ?>
        <?php if(array_key_exists('seo_countries', $links_map)) echo link_to($links_map['seo_countries'], '@seo_countries') ?><br />
    <?php endif; ?>
    <div style='width: 100%; height: 2px;'></div>
    <?php if(array_key_exists('user_agreement', $links_map)) echo link_to($links_map['user_agreement'], '@page?slug=user_agreement') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('privacy_policy', $links_map)) echo link_to($links_map['privacy_policy'], '@page?slug=privacy_policy') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('IMBRA', $links_map)) echo link_to($links_map['IMBRA'], '@page?slug=IMBRA') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('for_law_enforcement', $links_map)) echo link_to($links_map['for_law_enforcement'], '@page?slug=for_law_enforcement') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('site_map', $links_map)) echo link_to($links_map['site_map'], '@page?slug=site_map') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('frequently_asked_questions', $links_map)) echo link_to($links_map['frequently_asked_questions'], '@page?slug=frequently_asked_questions') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('contact_us', $links_map)) echo link_to($links_map['contact_us'], '@page?slug=contact_us') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('affiliates', $links_map)) echo link_to($links_map['affiliates'], '@page?slug=affiliates') . '&nbsp;&nbsp;&bull;&nbsp;'  ?>
    <?php if(array_key_exists('tell_friend', $links_map)) echo link_to($links_map['tell_friend'], 'content/tellFriend') ?><br />
<?php endif; ?>
