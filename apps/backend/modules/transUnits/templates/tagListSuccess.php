<?php foreach ($tags as $tag ): ?>
    <?php echo link_to($tag, 'transUnits/list?filter=filter&filters[tags]=' . $tag) ?> &nbsp;
<?php endforeach; ?>