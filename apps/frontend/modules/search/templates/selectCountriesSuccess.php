<?php echo __('Select the countries you want to find members in.') ?><br /><br />
<?php echo link_to(__('Cancel and return to search'), $sf_user->getRefererUrl(), array('class' => 'sec_link_small')) ?>
<form action="<?php echo url_for('search/selectCountries')?>" id="countries" method="post">
    <input type="submit" value="Save" class="save" /><br />
    <fieldset class="fieldcountry">
            <?php $p_char = '';$i=1;foreach ($countries as $key => $value): ?>
                <?php if( $value{0} != $p_char ): ?>
                    <legend><span><?php echo $value{0}; $p_char = $value{0} ?></span></legend>    
                <?php endif; ?>
                
                <?php echo checkbox_tag('countries[]', $key, in_array($key, $sf_data->getRaw('selected_countries'))) ?>
                <label><?php echo $value ?></label><br />
                <?php if( ++$i % 81 == 0 ): ?>
                </fieldset>
                <fieldset class="fieldcountry">
                <?php endif; ?>
            <?php endforeach; ?>
        </fieldset>
    <br class="clear" />
    <input type="submit" value="Save" class="save" />
</form>
