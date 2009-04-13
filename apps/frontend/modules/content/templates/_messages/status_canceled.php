<?php slot('header_title') ?>
<?php echo __('Status canceled headline') ?>
<?php end_slot(); ?>

<?php echo __('Status canceled body',
             array('{USER_AGREEMENT_URL}' => url_for('@page?slug=user_agreement'),
                    '{CONTACT_US_URL}' => url_for('@page?slug=contact_us')
                    )
             ) ?>