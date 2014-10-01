<?php use_helper('Javascript', 'dtForm') ?>

<?php echo __('Select the countries you want to find members in.') ?><br /><br />

<form action="<?php echo url_for('search/selectCountries')?>" id="countries" name="countries_form" method="post">
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?>
    <?php echo link_to(__('Cancel'), $sf_user->getRefererUrl(), array('class' => 'button cancel')) ?><br /><br /><br />

    <?php echo __('Select:'); ?>&nbsp;
    <?php echo link_to_function(__('All'), 'SC_select_all(document.forms.countries_form.elements["countries[]"], true)', array('class' => 'sec_link')) ?>&nbsp;
    <?php echo link_to_function(__('None'), 'SC_select_all(document.forms.countries_form.elements["countries[]"], false)', array('class' => 'sec_link')) ?><br />

    <?php foreach($countries_columns as $column_key => $countries_column): ?>
    <table>
      <?php if( $column_key == 'left'): ?>
        <tr><th>&nbsp;</th></tr>
        <tr><td>
        <?php echo checkbox_tag('countries[]', 'US', in_array('US', $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>
            <?php echo pr_format_country('US') ?>
            <?php if( in_array('US', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select states)'), 'search/selectAreas?country=US',
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "US", "'. url_for('search/selectAreas?select_all=1&country=US') .'")')) ?>
            <?php endif; ?>
        </td></tr>

        <tr><td>
        <?php echo checkbox_tag('countries[]', 'PL', in_array('PL', $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>
        <?php echo pr_format_country('PL') ?>
        <?php if( in_array('PL', $sf_data->getRaw('adm1s')) ): ?>
            <?php echo link_to(__('(select cities)'), 'search/selectAreas?country=PL',
                  array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "PL", "'. url_for('search/selectAreas?select_all=1&country=PL') .'")')) ?>
        <?php endif; ?>
        </td></tr>

        <tr><td>
        <?php echo checkbox_tag('countries[]', 'GB', in_array('GB', $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>
        <?php echo pr_format_country('GB') ?>
        <?php if( in_array('GB', $sf_data->getRaw('adm1s')) ): ?>
            <?php echo link_to(__('(select counties)'), 'search/selectAreas?country=GB',
                  array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "GB", "'. url_for('search/selectAreas?select_all=1&country=GB') .'")')) ?>
        <?php endif; ?>
        </td></tr>

        <tr><td>
        <?php echo checkbox_tag('countries[]', 'IE', in_array('IE', $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>
        <?php echo pr_format_country('IE') ?>
        <?php if( in_array('IE', $sf_data->getRaw('adm1s')) ): ?>
            <?php echo link_to(__('(select counties)'), 'search/selectAreas?country=IE',
                  array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "IE", "'. url_for('search/selectAreas?select_all=1&country=IE') .'")')) ?>
        <?php endif; ?>
        </td></tr>

        <tr><td>
        <?php echo checkbox_tag('countries[]', 'CA', in_array('CA', $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>
        <?php echo pr_format_country('CA') ?>
        <?php if( in_array('CA', $sf_data->getRaw('adm1s')) ): ?>
            <?php echo link_to(__('(select provinces)'), 'search/selectAreas?country=CA',
                  array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "CA", "'. url_for('search/selectAreas?select_all=1&country=CA') .'")')) ?>
        <?php endif; ?>
        </td></tr>

      <?php endif;?>

      <?php $p_char = '';$i=1;?>
      <?php foreach ($countries_column as $key => $value): ?>
          <?php $char = mb_substr($value, 0, 1, 'UTF-8'); ?>
          <?php if( $char != $p_char ): ?>
          <tr>
            <th>
              <span><?php echo $char; $p_char = $char ?></span>
            </th>
          </tr>
          <?php endif; ?>
          <tr>
            <td>
              <?php echo checkbox_tag('countries[]', $key, in_array($key, $sf_data->getRaw('selected_countries')), array('onchange' => 'select_same_countries(this)')) ?>

              <?php echo $value ?>
              <?php if( in_array($key, $sf_data->getRaw('adm1s')) ): ?>
                  <?php echo link_to(__('(select areas)'), 'search/selectAreas?country=' . $key,
                        array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "' . $key .'", "'. url_for('search/selectAreas?select_all=1&country=' . $key) .'")')) ?>
              <?php endif; ?>
            </td>
          </tr>
      <?php endforeach; ?>
    </table>
    <?php endforeach; ?>

    <br class="clear" />
    <br/>
    <?php echo submit_tag(__('Save'), array('class' => 'button', 'style' => 'margin: 5px;')) ?>
    <?php echo link_to(__('Cancel'), $sf_user->getRefererUrl(), array('class' => 'button cancel')) ?>
</form>
