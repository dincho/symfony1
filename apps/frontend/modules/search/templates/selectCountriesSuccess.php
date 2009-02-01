<?php use_helper('Javascript') ?>

<?php echo __('Select the countries you want to find members in.') ?><br /><br />

<form action="<?php echo url_for('search/selectCountries')?>" id="countries" method="post">
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?><br />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?><br />
    <fieldset class="fieldcountry">
            <?php $p_char = '';$i=1;foreach ($countries as $key => $value): ?>
                <?php if( $value{0} != $p_char ): ?>
                    <legend><span><?php echo $value{0}; $p_char = $value{0} ?></span></legend>    
                <?php endif; ?>
                
                <?php echo checkbox_tag('countries[]', $key, in_array($key, $sf_data->getRaw('selected_countries'))) ?>
                <label>
                    <?php echo $value ?>
                    <?php if( in_array($key, $sf_data->getRaw('states')) ): ?>
                        <?php echo link_to(__('(select areas)'), 'search/selectAreas?country=' . $key, 
                              array('class' => 'sec_link', 'onclick' => 'select_all_areas(this, "' . $key .'", "'. url_for('search/selectAreas?select_all=1&country=' . $key) .'")')) ?>
                    <?php endif; ?>
                </label><br />
                <?php if( ++$i % 81 == 0 ): ?>
                </fieldset>
                <fieldset class="fieldcountry">
                <?php endif; ?>
            <?php endforeach; ?>
        </fieldset>
    <br class="clear" />
    <?php echo submit_tag(__('Save'), array('class' => 'button')) ?><br />
    <?php echo link_to_function(__('Cancel and return to search'), 'window.history.go(-1)', array('class' => 'sec_link_small')) ?>
</form>
