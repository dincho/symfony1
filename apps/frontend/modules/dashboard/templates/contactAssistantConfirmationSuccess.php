<div id="assistant_profile_confirm">
    <?php if( $photo ): ?>
        <?php echo image_tag( ($photo->getImageUrlPath('cropped', '70x105')) ? $photo->getImageUrlPath('cropped', '70x105') : $photo->getImageUrlPath('file', '70x105')) ?>
    <?php endif; ?>
    <p><?php echo __('Assistant response content') ?></p>
    <br class="clear" />
</div>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
