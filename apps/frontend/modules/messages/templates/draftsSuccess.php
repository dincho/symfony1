<?php use_helper('prDate', 'Javascript', 'prProfilePhoto') ?>

<?php include_component('messages', 'navigation', array('active' => 'drafts')); ?>
<?php include_partial('content/pager', array('pager' => $pager, 'route' => 'messages/drafts')); ?><br />

<?php if($pager->getNbResults() > 0): ?>
    <?php if($sf_request->hasParameter('confirm_delete_draft')): ?>
        <?php $action = 'messages/deleteDraft' ?>
    <?php else: ?>
        <?php $action = 'messages/drafts?confirm_delete_draft=1&form_id=messages_form_draft'; ?>
    <?php endif; ?>

    <?php echo form_tag($action, array('id' => 'messages_form_draft', 'name' => 'messages_form_draft')) ?>    
        <?php include_partial(
            'actionsdraft',
            array(
                'form_name' => 'messages_form_draft', 
                'no_read_unread' => true
            )
        ); ?>
        <table cellspacing="0" cellpadding="0" class="messages" id="draft_messages"> 
        <?php foreach ($pager->getResults() as $message): ?>
            <?php unset($class); ?>
            <?php $is_selected = in_array($message->getId(), $sf_data->getRaw('sf_request')->getParameter('selected', array())) ?>
            <?php if( $sf_request->getParameter('confirm_delete_draft') && $is_selected ): ?> 
                <?php $class = 'delete'; ?>
            <?php endif; ?>
            
            <?php if( $message->getThreadId() ): ?>
                <?php $message_form_link = 'messages/thread?draft_id='.$message->getId().'&id=' . $message->getThreadId() ?>
            <?php else: ?>
                <?php $message_form_link = 'messages/send?draft_id='.$message->getId().'&recipient_id=' . $message->getRecipientId() ?>
            <?php endif; ?>

            <tr <?php if(isset($class)) echo 'class="' . $class . '"'?> >
                <td class="unread_circle">&nbsp;</td>          
                <td class="checkboxes"><?php echo checkbox_tag('selected[]', $message->getId(), $is_selected, array('class' => 'checkbox')) ?></td>
              
                <td class="profile_image"><?php echo link_to(profile_thumbnail_photo_tag($message->getMemberRelatedByRecipientId()), '@profile?username=' . $message->getMemberRelatedByRecipientId()->getUsername()); ?></td>
                <td class="message_from">
                <?php echo link_to($message->getMemberRelatedByRecipientId()->getUsername(), '@profile?username=' . $message->getMemberRelatedByRecipientId()->getUsername(), array('class' => 'sec_link')) ?>
                <br />
                    <?php echo format_date_pr($message->getUpdatedAt(null), null, 'dd-MMM-yyyy', $member->getTimezone()) ?>
                </td>
                <td class="message_body">
                    <?php echo link_to(Tools::truncate($message->getBody(), 80), $message_form_link, array('class' => 'sec_link')) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
        <?php include_partial(
            'actionsdraft',
            array(
                'form_name' => 'messages_form_draft', 
                'no_read_unread' => true
            )
        ); ?>
    </form>
<?php endif; ?>

<br />
<?php include_partial('content/pager', array('pager' => $pager, 'route' => 'messages/drafts')); ?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
