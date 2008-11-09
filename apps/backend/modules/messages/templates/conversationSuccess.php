<?php use_helper('Javascript') ?>
<?php include_partial('member_details', array('member' => $member)); ?>

<?php echo form_tag('messages/delete') ?>
<?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>
    <br />
    <div class="legend">Conversation with <?php echo $recipient->getUsername() ?></div>
    <div class="scrollable normal_scrollable" style="margin-top: 20px;">
            
        <?php foreach ($messages as $message): ?>
        <div class="conversation_box">
            <h4>
                <span class="conv_date"><?php echo $message->getCreatedAt('m/d/Y'); ?></span>
                <?php echo checkbox_tag('marked[]', $message->getId(), null) ?>
                <span class="conv_username">
                    <?php echo $message->getId() ?>
                    <?php $user = ($message->getFromMemberId() == $member->getId() ) ? 'To ' : 'From '; ?>
                    <?php $user .= $recipient->getUsername() ?>                
                    <?php echo link_to_function($user, 'show_hide("message_content_' . $message->getId() .'")') ?>
                </span>
                <?php echo Tools::truncate($message->getSubject(), 100); ?>
            </h4>
            <p id="message_content_<?php echo $message->getId();?>" style="display: none;"><?php echo $message->getContent() ?></p>
        </div>
        <?php endforeach; ?>
        
    </div>

    <div class="text-left">
        <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected messages?') ?>
    </div>

</form>
