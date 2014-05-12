<?php use_helper('Javascript', 'Number', 'xSortableTitle') ?>

<div class="filter_right"><?php echo button_to ('Compose Email', 'feedback/compose') ?></div>
<?php if( $pager->getNbResults() > 0): ?>
    <?php include_partial('members/search_filter', array('filters' => $filters)); ?>

    <?php echo form_tag('feedback/delete') ?>
        <table class="zebra">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo sortable_title('Date', 'Feedback::created_at', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('From', 'Feedback::mail_from', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Full Name', 'Feedback::name_from', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Subject', 'Feedback::subject', $sort_namespace) ?></th>
                </tr>
            </thead>

        <?php foreach ($pager->getResults() as $message): ?>
            <tr rel="<?php echo url_for('feedback/read?id=' . $message->getId()) ?>" <?php if(!$message->isRead()) echo 'class="unread"'; ?> onmouseover="javascript:document.getElementById('preview_<?php echo $message->getId();?>').click()">
                <td class="marked"><?php echo checkbox_tag('marked[]', $message->getId(), null) ?></td>
                <td><?php echo $message->getCreatedAt('m/d/Y'); ?></td>
                <?php if( $message->getMemberId() ): ?>
                    <td><?php echo $message->getMember()->getUsername() ?></td>
                    <td><?php echo $message->getMember()->getFullName() ?></td>
                <?php else: ?>
                    <td><?php echo $message->getMailFrom(); ?></td>
                    <td><?php echo $message->getNameFrom(); ?></td>
                <?php endif; ?>
                <td><?php echo Tools::truncate(strip_tags($message->getSubject()), 100); ?></td>
                <td class="preview_button">
                    <?php echo button_to_remote('Preview', array('url' => 'ajax/getFeedbackById?id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
                </td>
            </tr>
        <?php endforeach; ?>

        </table>
        <div class="actions">
            <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected messages?') ?>
        </div>
    </form>

    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'feedback/list')); ?>
    <div id="preview"></div>
<?php else: ?>
    <p>No messages.</p>
<?php endif; ?>
