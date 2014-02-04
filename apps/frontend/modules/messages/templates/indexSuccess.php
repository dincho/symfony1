<?php use_helper('prDate', 'Javascript', 'prProfilePhoto') ?>

<?php include_component('messages', 'navigation', array('active' => 'received')); ?>
<?php include_partial('content/pager', array('pager' => $pager, 'route' => 'messages/index')); ?><br />

<?php if($pager->getNbResults() > 0): ?>
    <?php if($sf_request->hasParameter('confirm_delete')): ?>
        <?php $action = 'messages/delete' ?>
    <?php else: ?>
        <?php $action = 'messages/index?confirm_delete=1&form_id=messages_form'; ?>
    <?php endif; ?>

    <?php echo form_tag($action, array('id' => 'messages_form', 'name' => 'messages_form', 'style' => '')) ?>
        <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
        <table cellspacing="0" cellpadding="0" class="messages">
        <?php foreach ($pager->getResults() as $thread): ?>
            <?php $class = ''; ?>
            <?php $is_selected = in_array($thread->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
            <?php if( !$thread->isRead() ) $class .= 'bold' ?>
            <?php if( $sf_request->getParameter('confirm_delete') && $is_selected ): ?>
                <?php $class .= 'delete'; ?>
            <?php endif; ?>

            <tr class="<?php echo $class ?>">
                <td class="unread_circle">
                    <?php if( !$thread->isRead() ): ?>
                        <?php echo image_tag('circle-blue.png'); ?>
                    <?php elseif( $thread->getSnippetMemberId() == $sf_user->getId() ): ?>
                        <?php echo image_tag('reply_left_arrow.png'); ?>
                    <?php else: ?>&nbsp;
                    <?php endif;?>
                </td>
                <td class="checkboxes"><?php echo checkbox_tag('selected[]', $thread->getId(), $is_selected, array('class' => 'checkbox', 'read' => (int) $thread->isRead())) ?></td>

                <td class="profile_image">
                    <?php if( $thread->object): ?>
                        <?php echo link_to(profile_thumbnail_photo_tag($thread->object), '@profile?username=' . $thread->object->getUsername()); ?>
                    <?php endif; ?>
                </td>
                <td class="message_from">
                    <?php if( $thread->object ): ?>
                        <?php echo link_to($thread->object->getUsername(), '@profile?username=' . $thread->object->getUsername(), array('class' => 'sec_link')) ?>
                        <?php if ($thread->getCntAll() > 1): ?>
                            <span class="message_count">(<?php echo $thread->getCntAll(); ?>)</span>
                        <?php endif; ?>
                        <br />
                    <?php else: ?>
                        <?php echo __('Internal System'); ?><br />
                    <?php endif; ?>
                    <a href="<?php echo url_for('messages/thread?mailbox=inbox&id=' . $thread->getId()); ?>" class="sec_link"><?php echo format_date_pr($thread->getUpdatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()); ?></a>
                </td>
                <td class="message_body">
                <a href="<?php echo url_for('messages/thread?mailbox=inbox&id=' . $thread->getId()); ?>" class="sec_link"><?php echo $thread->getSubject(); ?></a><!--
             --><?php if ($thread->getCntDrafts() > 0): ?>, <span class="draft"><?php echo __('Draft'); ?></span><?php endif; ?>
                    <br />
                    <?php echo Tools::truncate($thread->getSnippet(), $truncateLimit) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
        <?php include_partial('actions', array('form_name' => 'messages_form', 'cnt_unread' => $cnt_unread)); ?>
    </form>
<?php else: ?>
    <p><?php echo __('You currently have no messages'); ?></p>
<?php endif; ?>

<br />
<?php include_partial('content/pager', array('pager' => $pager, 'route' => 'messages/index')); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
