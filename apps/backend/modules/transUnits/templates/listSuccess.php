<?php use_helper('Object', 'xSortableTitle'); ?>

<div class="filter_right">
    <?php echo button_to ('Clear Cache', 'system/clearI18NCache') ?>
    <?php echo button_to ('Add Translation Unit', 'transUnits/create') ?>
</div>

<?php echo form_tag('transUnits/list', array('method' => 'get', 'id' => 'search_filter')) ?>
    <?php echo input_hidden_tag('filter', 'filter', 'class=hidden') ?>
    <fieldset class="search_fields">
        <label for="query">Source:</label><br />
        <?php echo input_tag('filters[search_query]', ( isset($filters['search_query']) ) ? $filters['search_query'] : null) ?>    
    </fieldset>
    <fieldset class="search_fields">
        <label for="target">Target:</label><br />
        <?php echo input_tag('filters[target]', ( isset($filters['target']) ) ? $filters['target'] : null) ?>    
    </fieldset>    
    <fieldset class="search_fields">
        <label for="tags">Tags:</label><br />
        <?php echo input_tag('filters[tags]', ( isset($filters['tags']) ) ? $filters['tags'] : null) ?>    
    </fieldset>
    <fieldset class="search_fields">
        <label for="cat_id">Catalog:</label><br />
        <?php echo select_tag('filters[cat_id]', objects_for_select($catalogs, 'getCatId', '__toString', isset($filters['cat_id']) ? $filters['cat_id'] : 'en')) ?>       
    
    </fieldset>
    <fieldset class="search_fields">
        <label for="filters[translated]" style="width: 80px">Translated:</label><br />
        <?php echo select_tag('filters[translated]', options_for_select(array('' => 'All', 0 => 'No', 1 => 'Yes'), isset($filters['translated']) ? $filters['translated'] : null), array('style' => 'width: 80px')) ?>       
    
    </fieldset>
    <fieldset>
        <label for="search">&nbsp;</label><br />
        <?php echo submit_tag('Search', 'id=search') ?>
        <?php echo button_to('Tags', 'transUnits/tagList')?>
    </fieldset>
</form>
<table class="zebra">
    <thead>
    <tr>
        <th><?php echo sortable_title('Source', 'TransUnit::source', $sort_namespace) ?></th>
        <th>Target</th>
        <th>Tags</th>
        <th><?php echo sortable_title('Created', 'TransUnit::date_added', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Modified', 'TransUnit::date_modified', $sort_namespace) ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pager->getResults() as $trans_unit): ?>
    <tr rel="<?php echo url_for('transUnits/edit?id=' . $trans_unit->getId()) ?>">
        <td><?php echo Tools::truncate($trans_unit->getSource(), 110) ?></td>
        <td><?php echo Tools::truncate($trans_unit->getTarget(), 110) ?></td>
        <td class="skip_me">
            <?php $tagStr = array(); ?>
            <?php foreach (explode(',', $trans_unit->getTags()) as $tag) : ?>
                <?php $tagStr[] = link_to(
                    Tools::truncate($tag, 110),
                    'transUnits/list?filter=filter',
                    array('query_string' => 'filters[tags]=' . urlencode($tag))
                ); ?>
            <?php endforeach ?>
            <?php echo implode(', ', $tagStr); ?>
        </td>
        <td><?php echo date('m/d/Y', $trans_unit->getDateAdded()); ?></td>
        <td><?php echo date('m/d/Y', $trans_unit->getDateModified()); ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'transUnits/list')); ?>