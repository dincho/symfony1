<?php use_helper('Javascript', 'prProfilePhoto') ?>
<?php include_partial('member_details', array('member' => $member)); ?>

<?php echo form_tag('messages/delete', array('name' => 'messages_conversation', )) ?>
<?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>
    <br />
    <?php $username = $profile->getUsername(); ?>
    <div class="legend">Conversation with <?php echo  $username; ?></div>
    <div>
        <?php echo link_to($username ."'s messages", 'messages/member?id=' . $profile->getId()); ?> |
        <?php echo link_to("see " . $username ."'s BE profile", 'members/edit?id=' . $profile->getId()); ?> |
        <?php echo link_to("see " . $username ."'s FE profile", $profile->getFrontendProfileUrl(), array('popup' => true)); ?>
        <?php echo  unless_profile_thumbnail_photo_tag($profile); ?>
    </div>
    <div>
        Select: <?php echo link_to_function('All', 'msg_select(document.forms.messages_conversation.elements["marked[]"], true)') ?>,
                <?php echo link_to_function('None', 'msg_select(document.forms.messages_conversation.elements["marked[]"], false)') ?>
    </div>
    <div class="scrollable normal_scrollable" style="margin-top: 20px;">

        <?php foreach ($messages as $message): ?>
        <div class="conversation_box">
            <h4>
                <span class="conv_date"><?php echo $message->getCreatedAt('m/d/Y'); ?></span>
                <?php echo checkbox_tag('marked[]', $message->getId(), null) ?>
                <span class="conv_username">
                    <?php $user = ($message->getSenderId() == $member->getId() ) ? 'To ' : 'From '; ?>
                    <?php $user .= $profile->getUsername() ?>
                    <?php echo link_to_function($user, 'show_hide("message_content_' . $message->getId() .'")') ?>
                </span>

            </h4>
            <p id="message_content_<?php echo $message->getId();?>" style="display: none;"><?php echo $message->getBody() ?></p>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="text-left">
        <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected messages?') ?>
    </div>

</form>
