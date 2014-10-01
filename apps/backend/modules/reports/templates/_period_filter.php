<script>
    public function cal_update(cal) { document.getElementById("period_filter").submit(); }
</script>
<?php echo form_tag($sf_context->getModuleName() . '/' . $sf_context->getActionName(), array('id' => 'period_filter', 'method' => 'get')) ?>
    <div>
        <?php echo input_hidden_tag('filter', 'filter') ?>
        <?php echo input_date_tag('filters[date_from]', ( isset($filters['date_from']) ) ? $filters['date_from'] : time() - 3*24*60*60,
                                  array('calendar_button_img' => '/sf/sf_admin/images/date.png',
                                  'format' => 'MM/dd/yy', 'rich' => true, 'readonly' => true, 'style' => 'width: 74px;', 'withtime' => false,
                                  'class' => '', 'calendar_options' => 'button: "filters_date_from", onUpdate: cal_update')) ?> -

        <?php echo input_date_tag('filters[date_to]', ( isset($filters['date_to']) ) ? $filters['date_to'] : time(),
                                  array('calendar_button_img' => '/sf/sf_admin/images/date.png',
                                  'format' => 'MM/dd/yy', 'rich' => true, 'readonly' => true, 'style' => 'width: 74px;', 'withtime' => false,
                                  'class' => '', 'calendar_options' => 'button: "filters_date_to", onUpdate: cal_update')) ?>
    </div>
</form>
