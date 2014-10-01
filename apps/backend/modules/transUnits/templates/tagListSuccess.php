<?php foreach ($tags as $tag ): ?>
    <?php echo link_to($tag, 'transUnits/list?filter=filter', array('query_string' => 'filters[tags]=' . urlencode($tag))) ?> &nbsp;
<?php endforeach; ?>
