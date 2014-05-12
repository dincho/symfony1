<?php use_helper('dtForm') ?>

<?php echo form_tag('photos/list', array('method' => 'get')) ?>
    <fieldset class="form_fields">
        <?php echo input_hidden_tag('filter', 'filter', array('class' => 'hidden')) ?>
        <?php echo input_hidden_tag('filters[by_country]', 1, array('class' => 'hidden')) ?>
        <?php echo input_hidden_tag('sort', 'no', array('class' => 'hidden')) ?>
        <div class="legend">Select Country Filter</div>
        <label for="filters[country]">Country:</label>
        <?php echo pr_select_country_tag('filters[country]', (isset($filters['country']) ? $filters['country'] : 'US' )) ?><br />
    </fieldset>
    <fieldset class="actions">
        <?php echo submit_tag('Apply') ?>
        <?php echo button_to('Cancel', 'photos/list?filter=filter&sort=no') ?>
    </fieldset>
</form>
