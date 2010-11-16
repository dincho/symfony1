<?php use_helper('Javascript', 'Number', 'xSortableTitle') ?>

<?php if( $pager->getNbResults() > 0): ?>
    <?php //include_partial('members/search_filter', array('filters' => $filters)); ?>

    <?php echo form_tag('feedback/outgoingMailResend') ?>
        <table class="zebra">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo sortable_title('Mail From', 'PrMailMessage::mail_from', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Recipients', 'PrMailMessage::recipients', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Subject', 'PrMailMessage::subject', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Created', 'PrMailMessage::created_at', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Updated', 'PrMailMessage::updated_at', $sort_namespace) ?></th>
                    <th><?php echo sortable_title('Status', 'PrMailMessage::status', $sort_namespace) ?></th>
                </tr>
            </thead>
            
        <?php foreach ($pager->getResults() as $message): ?>
            <tr rel="<?php echo url_for('feedback/outgoingRead?id=' . $message->getId()) ?>" onmouseover="javascript:document.getElementById('preview_<?php echo $message->getId();?>').click()">
                <td class="marked">
                    <?php if( in_array($message->getStatus(), array(PrMailMessagePeer::STATUS_PENDING, PrMailMessagePeer::STATUS_FAILED)) ): ?>
                        <?php echo checkbox_tag('marked[]', $message->getId(), null) ?>
                    <?php endif; ?>
                </td>
                <td><?php echo esc_entities($message->getMailFrom()); ?></td>
                <td><?php echo esc_entities(implode(",", $message->getRecipients())); ?></td>
                <td><?php echo Tools::truncate(strip_tags($message->getSubject()), 100); ?></td>
                <td><?php echo $message->getCreatedAt('m/d/Y H:i:s'); ?></td>
                <td><?php echo $message->getUpdatedAt('m/d/Y H:i:s'); ?></td>
                <td style="color: <?php echo status_color($message->getStatus());?>;"><?php echo $message->getStatus(); ?></td>
                <td class="preview_button">
                    <?php echo button_to_remote('Preview', array('url' => 'ajax/getPrMailMessageById?id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        
        </table>
        <div class="actions">
            <?php echo submit_tag('Retry', 'confirm=Are you sure you want to retry selected messages?'); ?>
        </div>
    </form>
    
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'feedback/outgoingMailList')); ?>
    <div id="preview"></div>
<?php else: ?>
    <p>No outgoing mail messages.</p>
<?php endif; ?>

<?php 
function status_color($status)
{
    switch ($status) {

        case PrMailMessagePeer::STATUS_SCHEDULED:
                return "orange";
            break;
            
        case PrMailMessagePeer::STATUS_SENDING:
                return "#9ACD32";
            break;
                                            
        case PrMailMessagePeer::STATUS_FAILED:
                return "red";
            break;
            
        case PrMailMessagePeer::STATUS_SENT:
                return "green";
            break;
        
        default:
                return "black";
            break;
    }
}
?>