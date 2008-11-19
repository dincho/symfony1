<div id="footer">
    <?php if( !$sf_user->isAuthenticated() ): ?>
        <?php echo link_to(__('Join Now'), 'registration/joinNow'); ?>&nbsp;&nbsp;&bull;&nbsp;
        <?php echo link_to(__('How it Works'), '@page?slug=how_it_works') ?>&nbsp;&nbsp;&bull;&nbsp;
        <?php echo link_to(__('About Us'), '@page?slug=about_us'); ?>&nbsp;&nbsp;&bull;&nbsp;
        <?php echo link_to(__('Help'), '@page?slug=help') ?>&nbsp;&nbsp;&bull;&nbsp;
        <a href="#">Search Engines</a><br />
    <?php endif; ?>
    <?php echo link_to(__('Terms of Use'), '@page?slug=user_agreement') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Privacy Policy'), '@page?slug=privacy_policy') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('IMBRA'), '@page?slug=IMBRA') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Legal'), '@page?slug=for_law_enforcement') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Site Map'), '@page?slug=site_map') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('FAQs'), '@page?slug=frequently_asked_questions') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Contact Us'), '@page?slug=contact_us') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Affilates'), '@page?slug=affiliates') ?>&nbsp;&nbsp;&bull;&nbsp;
    <?php echo link_to(__('Tell a Friend'), 'content/tellFriend') ?><br />
    <span class="footer_footer"><?php echo link_to('&copy; Copyright 2007-2008 by PolishRomance.com v0.9.1 ', '@page?slug=copyright') ?>- Patent Pending - All Rights Reserved - <?php include_partial('system/page_execution'); ?></span>
</div>