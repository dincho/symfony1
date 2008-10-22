<?php include_partial('searchTypes'); ?>

<form action="">
    <label for="id_user">Enter profile ID, e.g. "999 9999"</label><input type="text" class="input_text_width" id="id_user" />
    <input type="submit" value="" class="public_matches_search" />
</form>

<?php if( isset($pager) ): ?>
    <?php include_partial('results', array('pager' => $pager, 'route' => 'search/profileId')); ?>
<?php endif; ?>


