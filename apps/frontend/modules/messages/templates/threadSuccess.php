<?php use_helper('Javascript', 'prDate', 'prLink', 'prProfilePhoto', 'dtForm', 'Window', 'Date') ?>

<?php echo javascript_tag('submitted = false;'); ?>

<div class="thread_actions">
    <div class="float-left">
        &bull;&nbsp;&nbsp;<?php echo link_to_function(__('back to previous page'), 'history.go(-1)'); ?> 
        &nbsp;&bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?>
    </div>
    <?php if($profile): ?>
        <div class="float-right">&bull;&nbsp;&nbsp;
            <?php echo link_to_prototype_window(__('Flag'), 'flag_profile', array('title'          => __('Flag %USERNAME%', array('%USERNAME%' => $profile->getUsername())), 
                                                                                    'url'            => 'content/flag?layout=window&username=' . $profile->getUsername(), 
                                                                                    'id'             => '"flag_profile_window"', 
                                                                                    'width'          => '550', 
                                                                                    'height'         => '200',
                                                                                    'center'         => 'true', 
                                                                                    'minimizable'    => 'false',
                                                                                    'maximizable'    => 'false',
                                                                                    'closable'       => 'true', 
                                                                                    'destroyOnClose' => "true",
                                                                                    'className'      => 'polishdate',
                                                                                ), 
                                                                             array('absolute'        => false, 
                                                                                   'id'              => 'flag_profile_link_window',
                                                                                   'class'           => 'sec_link',
                                                                                 )); ?>
        </div>
        <div class="float-right">&bull;&nbsp;&nbsp;
            <?php $block_link_title = ( $sf_user->getProfile() && $sf_user->getProfile()->hasBlockFor($profile->getId()) ) ? __('Unblock') : __('Block'); ?>
            <?php echo link_to_remote($block_link_title,
                                      array('url'     => 'block/toggle?update_selector=block_link&profile_id=' . $profile->getId(),
                                            'update'  => 'msg_container',
                                            'script'  => true
                                          ),
                                      array('class' => 'sec_link',
                                            'id'    => 'block_link', 
                                            )
                        ); ?>
            &nbsp;&nbsp;
        </div>
    <?php endif; ?>
    
    <br class="clear" />
</div>
<div id="loader">
    <?php echo link_to_remote(__('View older messages'), array(
                'update' => 'messages',
                'position' => 'top',
                'url' => 'messages/getMoreMessages?id='.$thread->getId(),
                'method' => 'GET',
                'with' => "'offset=' + this.getAttribute('data-offset')",
                'loading' => 'showLoading()',
                'success' => 'read(request)',
            ), array(
                'id' => 'fetch_link',
                'data-offset' => count($messages),
                'data-limit' => $limit,
                'style' => ($displayFetchLink) ? "display: inline" : "display: none",
            )
        ); ?>
        <span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span>
        <?php echo link_to_function(__('View the last messages'),  'location.reload()', array('style' => 'display: none')) ?>
</div>
<div id="messages">
    <?php include_partial('get_messages', array('messages' => $messages, 'member' => $member, 'profile' => $profile)); ?>
</div>
<?php if( $profile && $profile->isActive() ): ?>
    <span id="feedback">&nbsp;</span>

    <?php echo form_tag('messages/thread', array('class'  => 'msg_form', 'id' => 'reply_message_form')) ?>
        <?php echo input_hidden_tag('id', $thread->getId(), 'class=hidden') ?>
        <?php echo input_hidden_tag('draft_id', $draft->getId(), 'class=hidden') ?>
        <?php if( $limit ): ?>
            <?php echo input_hidden_tag('limit', $limit, array('class' => 'hidden')) ?>
        <?php endif; ?>
        <?php if( $displayFetchLink ): ?>
            <?php echo input_hidden_tag('displayFetchLink', $displayFetchLink, array('class' => 'hidden')) ?>
        <?php endif; ?>
        <?php echo input_hidden_tag('numberOfMessages', count($messages), array('class' => 'hidden', 'id' => 'numberOfMessages')) ?>
        <fieldset class="thread_msg">
            <?php echo pr_label_for('your_story', __('Message:')) ?>
            <div id="thread_text"><?php echo __('Never include your last name, e-mail address, home address, phone number, place of work and any other identifying information in initial messages with other members'); ?>
            </div>
            <?php echo textarea_tag('content',  isset($content)? $content : $draft->getBody(), array('id' => 'your_story', 'rows' => 10, 'cols' => 30)) ?>
            <br />
        </fieldset>
    
        <fieldset class="thread_actions">
            <label></label>
            <?php echo submit_tag(__('Send'), array(
                'class' => 'button',
                'onclick' => "if(submitted) return false;
                              document.getElementById('feedback').innerHTML = '".__('Sending message...')."';
                              submitted = true; return true;"
            )) ?>
            <?php echo button_to_function(__('Save Now'), 'save_draft();', array('class' => 'button', 'id' => 'save_to_draft_btn')) ?>
            <?php echo button_to(__('Discard'), 'messages/discard?draft_id=' . $draft->getId(), array('class' => 'button cancel', )) ?>
            <br />
        </fieldset>
    </form>

    <?php include_partial('draft_save', array('draft' => $draft)); ?>
<?php endif; ?>

<br /><br />
<div class="thread_actions">
        &bull;&nbsp;&nbsp;<?php echo link_to_function(__('back to previous page'), 'history.go(-1)'); ?> 
        &nbsp;&bull;&nbsp;&nbsp;<?php echo link_to(__('Back to Inbox'), 'messages/index', array('class' => 'sec_link')); ?>
</div>

<?php echo javascript_tag('
    Event.observe(window, "load", function() {
       if($("your_story")) {
          $("your_story").focus();
       }
    });
');?>

<?php echo javascript_tag('
    var temp = "";
    function read(ajax){
        document.getElementById("loader").innerHTML = temp;
        var el = document.getElementById("fetch_link");
        var currentOffset = parseInt(el.getAttribute("data-offset"), 10);
        if (ajax.getResponseHeader("displayFetchLink")){
            el.setAttribute("data-offset", parseInt(el.getAttribute("data-limit"), 10) + currentOffset);
            el.style.display = "inline";
        } else {
            el.style.display = "none";
            document.forms[0].displayFetchLink.value = 0;
        }
        var currentMessNum = parseInt(document.getElementById("numberOfMessages").value);
        document.getElementById("numberOfMessages").value = currentMessNum + parseInt(ajax.getResponseHeader("numberOfMessages"));
        if (document.getElementById("numberOfMessages").value > 5) {
            Element.siblings(el).each(function(node){
                if (node.nodeName == "SPAN") {
                    node.style.display = el.style.display
                }
                else {
                    node.style.display = "inline";
                }
            });
        }
    }
    function showLoading(){
        var el = document.getElementById("loader");
        temp = el.innerHTML;
        el.innerHTML = "<img src=\"/images/ajax-loader-bg-2B2B2B.gif\" alt=\"Loading...\" />";
    }
')
?>

<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>
