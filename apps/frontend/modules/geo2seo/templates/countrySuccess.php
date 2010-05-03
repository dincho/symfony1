<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<hr />
<?php include_component('geo2seo', 'profiles'); ?>
<hr />

<?php $adms = $sf_data->getRaw('adms'); ?>
<?php $cnt = count($adms); ?>
<?php $columns = 5; ?>
<?php $itemsPerColumn = ceil($cnt/$columns); ?>

<table class="geo_columns">
    <?php for($row_index = 1; $row_index <= $itemsPerColumn; $row_index++): ?>
        <tr>
            <?php for($column_index = 1; $column_index <= $columns; $column_index++): ?>
                <td>
                    <?php $index = ($row_index+$column_index*$itemsPerColumn-$itemsPerColumn-1); ?>
                    <?php if( isset($adms[$index]) ): ?>
                        <?php echo link_to($adms[$index]->getName(), '@adm1_info?country_iso=' . $country_iso . 
                                                                                        '&country_name=' . $country_name. 
                                                                                        '&adm1_id=' . $adms[$index]->getId() . 
                                                                                        '&adm1_name=' . $adms[$index]->getName()); ?>                    
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr> 
    <?php endfor; ?>
</table>
