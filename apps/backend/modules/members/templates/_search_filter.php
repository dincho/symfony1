<?php echo form_tag(sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName(), array('method' => 'get', 'id' => 'search_filter')) ?>
    <?php if( isset($extra_vars)): ?>
        <?php foreach ($extra_vars as $name => $value): ?>
            <?php echo input_hidden_tag($name, $value) ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo input_hidden_tag('filter', 'filter', 'class=hidden') ?>
    <fieldset class="search_fields">
        <label for="query">Search for:</label><br />
        <?php echo input_tag('filters[search_query]', ( isset($filters['search_query']) ) ? $filters['search_query'] : null) ?>
    </fieldset>
    <fieldset class="search_fields">
        <label for="search_type">Search by:</label><br />
        <?php echo select_tag('filters[search_type]',
                            options_for_select(array('username' => 'Username',
                                                     'first_name' => 'First Name',
                                                     'last_name' => 'Last Name',
                                                      'email' => 'Email', ),
                            ( isset($filters['search_type']) ) ? $filters['search_type'] : null)) ?>
    </fieldset>
    <fieldset>
        <label for="search">&nbsp;</label><br />
        <?php echo submit_tag('Search', 'id=search') ?>
    </fieldset>
</form>
