<?php slot('header_title') ?>
    <?php echo __('Sorry') ?>
<?php end_slot(); ?>

<?php echo __('Sorry, your account has been removed by website administration due to the violation of our 
               <a href="{USER_AGREEMENT_URL}" class="sec_link">Terms of Use</a> (spamming, scamming, suspicious activities, 
               use of a stolen credit card, harassing other members, advertising other services, or other abuses). 
               If you were a paid member, you will not be charged again. 
               If you believe your suspension is a mistake, please <a href="{CONTACT_US_URL}" class="sec_link">contact us</a>.',
             array('{USER_AGREEMENT_URL}' => url_for('@page?slug=user_agreement'),
                    '{CONTACT_US_URL}' => url_for('@page?slug=contact_us')
                    )
             ) ?>