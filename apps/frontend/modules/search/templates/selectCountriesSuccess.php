<?php echo __('Select the countries you want to find members in.') ?><br /><br />

<form action="<?php echo url_for('search/selectCountries')?>" id="countries" method="post">
    <?php echo link_to(__('Cancel and return to search'), $sf_user->getRefererUrl(), array('class' => 'sec_link_small')) ?><br />
    <input type="submit" value="Save" class="save" /><br />
    <fieldset class="fieldcountry">
            <?php $p_char = '';$i=1;foreach ($countries as $key => $value): ?>
                <?php if( $value{0} != $p_char ): ?>
                    <legend><span><?php echo $value{0}; $p_char = $value{0} ?></span></legend>    
                <?php endif; ?>
                
                <?php echo checkbox_tag('countries[]', $key, in_array($key, $sf_data->getRaw('selected_countries'))) ?>
                <label>
                    <?php echo $value ?>
                    <?php if( in_array($key, $sf_data->getRaw('states')) ): ?>
                        <?php echo link_to(__('(select areas)'), 'search/selectAreas?country=' . $key, array('class' => 'sec_link')) ?>
                    <?php endif; ?>
                </label><br />
                <?php if( ++$i % 81 == 0 ): ?>
                </fieldset>
                <fieldset class="fieldcountry">
                <?php endif; ?>
            <?php endforeach; ?>
        </fieldset>
    <br class="clear" />
    <input type="submit" value="Save" class="save" /><br />
    <?php echo link_to(__('Cancel and return to search'), $sf_user->getRefererUrl(), array('class' => 'sec_link_small')) ?>
</form>
