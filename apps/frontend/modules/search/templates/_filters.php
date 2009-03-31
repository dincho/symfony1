    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody><tr bgcolor="#3d3d3d">
        <td colspan="5">
        <?php echo checkbox_tag('filters[only_with_video]', 1, isset($filters['only_with_video'])) ?>&nbsp;
        <?php echo __('Show only profiles with video') ?>
        </td>
    </tr>
    <tr>
        <td colspan="5" bgcolor="Black" style="height: 1px;"></td>
    </tr>
    <tr bgcolor="#3d3d3d">
        <td style="padding: 10px 0pt 2px 5px;"><strong><?php echo __('Location') ?></strong></td>
        <td> <?php echo radiobutton_tag('filters[location]', 0, ($filters['location'] == 0) ) ?>&nbsp;
                <?php echo __('Everywhere') ?>
        </td>

        <td>
         <?php echo radiobutton_tag('filters[location]', 1, ($filters['location'] == 1) ) ?>&nbsp;
        <?php echo __('In selected countries only') ?>
        </td>
        <td><?php echo radiobutton_tag('filters[location]', 2, ($filters['location'] == 2) ) ?>&nbsp;
        <?php echo __('In my area only') ?>
        </td>
        <td><?php echo checkbox_tag('filters[include_poland]', 1, isset($filters['include_poland'])  ) ?>&nbsp;
        <?php echo __('Include matches in Poland') ?>
        </td>
    </tr>
    <tr bgcolor="#3d3d3d">
        <td></td>
        <td></td>

        <td style="padding-left: 20px;"><?php echo link_to(__('Select Countries'), 'search/selectCountries') ?></td>
        <td></td>
        <td style="padding-left: 20px;"><?php echo link_to(__('Select Cities'), 'search/selectAreas?country=PL&polish_cities=1') ?></td>
    </tr>
    <tr>
        <td colspan="5" style="padding: 4px 0pt;" align="eft">
        <?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results')")) ?>
        </td>

    </tr>

</tbody>
</table> 
</form>