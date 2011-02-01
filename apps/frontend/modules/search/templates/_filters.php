    <?php use_helper('Javascript', 'Date', 'dtForm') ?>

    <table border="0" cellpadding="0" cellspacing="0" class="search_filter">
      <tbody>
        <tr class="search_filter_top_row">
            <td colspan="4"><?php echo checkbox_tag('filters[only_with_photo]', 1, isset($filters['only_with_photo'])) . __('Show only profiles with photo') ?></td>
            <td></td>
        </tr>
        <tr class="search_filter_bottom_row">
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr class="separator">
            <td colspan="5"></td>
        </tr>
        <tr class="search_filter_middle_row">
            <td class="search_filter_row_label"><?php echo __('Location') ?></td>
            <td><?php echo radiobutton_tag('filters[location]', 0, ($filters['location'] == 0), array('onchange' => "this.form.submit();show_load();")) . __('Everywhere') ?>
            </td>
            <td><?php echo radiobutton_tag('filters[location]', 1, ($filters['location'] == 1), array('onchange' => "this.form.submit();show_load();")) . __('In selected countries only') ?>
            </td>
            <td><?php echo radiobutton_tag('filters[location]', 2, ($filters['location'] == 2), array('onchange' => "this.form.submit();show_load();")) . __('Within') ?>&nbsp;
                <?php echo input_tag('filters[radius]', isset($filters['radius'])?$filters['radius']:sfConfig::get('app_settings_search_default_radius_distance'), array('class' => 'input_radius')) ?>
                &nbsp;
                <?php echo select_tag('filters[kmmils]',  options_for_select(array( 'mil' => __('mil'), 'km' => __('km')), isset($filters['kmmils'])?$filters['kmmils']:sfConfig::get('app_settings_search_default_kilometers_miles')), array('class' => 'select_radius')) ?>
                &nbsp;<?php echo __('radius from my city') ?>
            </td>
            <td></td>
        </tr>
        <tr class="search_filter_bottom_row">
            <td></td>
            <td></td>
    
            <td><?php echo link_to(__('Select Countries'), 'search/selectCountries', array('class' => 'sec_link')) ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="actions">
            <td colspan="5">
              <?php echo submit_tag(__('Search'), array('class' => 'button','name' => 'filter', 'onclick' => "show_loader('match_results','".__('Updating Results...')."')")) ?>
            </td>
        </tr>
      </tbody>
  </table> 
</form>
<span id="loading" class="loading" style="display: none;">
  <?php echo image_tag('loading.gif') ?>
  <br>
  <?php echo __('Updating Results...')?>
</span>
