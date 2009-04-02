    <table border="0" cellpadding="0" cellspacing="0" class="search_filter">
	    <tbody>
		    <tr class="search_filter_tr_1">
		        <td colspan="5">
		        <?php echo checkbox_tag('filters[only_with_video]', 1, isset($filters['only_with_video'])) ?>&nbsp;
		        <?php echo __('Show only profiles with video') ?>
		        </td>
		    </tr>
		    <tr>
		        <td colspan="5" class="search_filter_td_2"></td>
		    </tr>
		    <tr class="search_filter_tr_1">
		        <td class="search_filter_td_3"><strong><?php echo __('Location') ?></strong></td>
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
		    <tr class="search_filter_tr_1">
		        <td></td>
		        <td></td>
		
		        <td class="search_filter_td_4"><?php echo link_to(__('Select Countries'), 'search/selectCountries') ?></td>
		        <td></td>
		        <td class="search_filter_td_4"><?php echo link_to(__('Select Cities'), 'search/selectAreas?country=PL&polish_cities=1') ?></td>
		    </tr>
		    <tr>
		        <td colspan="5" class="search_filter_td_5" >
		        <?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results')")) ?>
		        </td>
		
		    </tr>
	    </tbody>
	</table> 
</form>