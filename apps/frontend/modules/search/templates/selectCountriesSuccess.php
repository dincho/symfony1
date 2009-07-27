<?php use_helper('Javascript') ?>

<?php echo __('Select the countries you want to find members in.') ?><br /><br />

<form action="<?php echo url_for('search/selectCountries')?>" id="countries" method="post">
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?><br />
    
    <fieldset class="fieldcountry">
        <legend><span style="border: none; height: 1px;">&nbsp;</span></legend> 
        
        <?php echo checkbox_tag('countries[]', 'US', in_array('US', $sf_data->getRaw('selected_countries'))) ?>
        <label>
            <?php echo format_country('US') ?>
            <?php if( in_array('US', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select states)'), 'search/selectAreas?country=US', 
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "US", "'. url_for('search/selectAreas?select_all=1&country=US') .'")')) ?>
            <?php endif; ?>            
        </label><br />
        
        <?php echo checkbox_tag('countries[]', 'PL', in_array('PL', $sf_data->getRaw('selected_countries'))) ?>
        <label>
            <?php echo format_country('PL') ?>
            <?php if( in_array('PL', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select cities)'), 'search/selectAreas?country=PL', 
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "PL", "'. url_for('search/selectAreas?select_all=1&country=PL') .'")')) ?>
            <?php endif; ?>             
        </label><br />
        
        <?php echo checkbox_tag('countries[]', 'GB', in_array('GB', $sf_data->getRaw('selected_countries'))) ?>
        <label>
            <?php echo format_country('GB') ?>
            <?php if( in_array('GB', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select counties)'), 'search/selectAreas?country=GB', 
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "GB", "'. url_for('search/selectAreas?select_all=1&country=GB') .'")')) ?>
            <?php endif; ?>              
        </label><br />
        
        <?php echo checkbox_tag('countries[]', 'IE', in_array('IE', $sf_data->getRaw('selected_countries'))) ?>
        <label>
            <?php echo format_country('IE') ?>
            <?php if( in_array('IE', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select counties)'), 'search/selectAreas?country=IE', 
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "IE", "'. url_for('search/selectAreas?select_all=1&country=IE') .'")')) ?>
            <?php endif; ?>               
        </label><br />
        
        <?php echo checkbox_tag('countries[]', 'CA', in_array('CA', $sf_data->getRaw('selected_countries'))) ?>
        <label>
            <?php echo format_country('CA') ?>
            <?php if( in_array('CA', $sf_data->getRaw('adm1s')) ): ?>
                <?php echo link_to(__('(select provinces)'), 'search/selectAreas?country=CA', 
                      array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "CA", "'. url_for('search/selectAreas?select_all=1&country=CA') .'")')) ?>
            <?php endif; ?>               
        </label><br />
    
            <?php $p_char = '';$i=1;foreach ($countries as $key => $value): ?>
                <?php if( $value{0} != $p_char ): ?>
                    <legend><span><?php echo $value{0}; $p_char = $value{0} ?></span></legend>    
                <?php endif; ?>
                
                <?php echo checkbox_tag('countries[]', $key, in_array($key, $sf_data->getRaw('selected_countries'))) ?>
                <label>
                    <?php echo $value ?>
                    <?php if( in_array($key, $sf_data->getRaw('adm1s')) ): ?>
                        <?php echo link_to(__('(select areas)'), 'search/selectAreas?country=' . $key, 
                              array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "' . $key .'", "'. url_for('search/selectAreas?select_all=1&country=' . $key) .'")')) ?>
                    <?php endif; ?>
                </label><br />
                <?php if( ++$i % 84 == 0 ): ?>
                </fieldset>
                <fieldset class="fieldcountry">
                <?php endif; ?>
            <?php endforeach; ?>
        </fieldset>
    <br class="clear" />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?><br />
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?>
</form>
