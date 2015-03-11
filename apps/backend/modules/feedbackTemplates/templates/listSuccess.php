<?php echo form_tag('feedbackTemplates/list', array('method' => 'get', 'id' => 'search_filter')) ?>
    <?php echo input_hidden_tag('filter', 'filter', 'class=hidden') ?>
    <fieldset class="search_fields">
        <label for="search_type">Search by:</label><br />
        <?php echo select_tag('filters[tags]', options_for_select(FeedbackTemplatePeer::getTagsWithKeys(),
            ( isset($filters['tags']) ) ? $filters['tags'] : null, array('include_blank' => true))) ?>
    </fieldset>
    <fieldset>
        <label for="search">&nbsp;</label><br />
        <?php echo submit_tag('Search', 'id=search') ?>
    </fieldset>
</form>

<div class="top_actions filter_right">
    <?php echo button_to('New Template', 'feedbackTemplates/create') ?>
</div>

<div class="tag_holder">
    <table>
        <thead>
            <tr>
                <td>
                    All tags:
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
                <tr>
                    <td>
                        <?php echo link_to(
                            Tools::truncate($tag, 110),
                            'feedbackTemplates/edit?filter=filter',
                            array('query_string' => 'filters[tag]=' . urlencode($tag))
                        ); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo form_tag('feedbackTemplates/delete') ?>
    <table class="zebra width_undo">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($templates as $template): ?>
            <tr rel="<?php echo url_for('feedbackTemplates/edit?id=' . $template->getId()) ?>">
                <td class="marked"><?php echo checkbox_tag('marked[]', $template->getId(), null) ?></td>
                <td><?php echo $template->getName() ?></td>
                <td class="skip_me">
                    <?php if ($template->getTags()) : ?>
                        <?php $tagStr = array(); ?>
                        <?php foreach (explode(',', $template->getTags()) as $tag) : ?>
                            <?php $tagStr[] = link_to(
                                Tools::truncate($tag, 110),
                                'feedbackTemplates/list?filter=filter',
                                array('query_string' => 'filters[tags]=' . urlencode($tag))
                            ); ?>
                        <?php endforeach; ?>
                        <?php echo implode(', ', $tagStr); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected templates?') ?>
</form>
