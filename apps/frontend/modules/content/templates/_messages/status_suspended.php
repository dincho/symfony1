<?php slot('header_title') ?>
    <?php echo __('Sorry') ?>
<?php end_slot(); ?>

<?php echo __('Sorry, your account has been suspended by website administration due to the violation of our 
              <a href="{USER_AGREEMENT_URL}" class="sec_link">Terms of Use</a> (spamming, scamming, suspicious activities, 
              use of a stolen credit card, harassing other members, advertising other services, or other abuses). 
              We will contact you by email to let you know if you can still user our website.',
        array('{USER_AGREEMENT_URL}' => url_for('@page?slug=user_agreement')));