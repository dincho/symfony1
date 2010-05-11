<?php use_helper('Object', 'Javascript'); ?>

<?php echo select_tag('predefined_message_id', 
                       objects_for_select($messages, 
                                            'getId', 
                                            'getSubject', 
                                            $sf_request->getParameter('predefined_message_id'),
                                            array('include_custom' => __('Custom Message (Paid Only)'))
                        ),
                        array('onchange' => 'predefined_message_selected(this.value)')
                    ) ;?>

<script type="text/javascript" charset="utf-8">

var predefined_messages = [];
var body_field = null;
var subject_field = null;
window.onload = init_predefined_messages;

function init_predefined_messages()
{
    predefined_messages = <?php echo $js_options; ?>;
    body_field = $('<?php echo $body_field_id; ?>');
    subject_field = $('<?php echo $subject_field_id; ?>');
}

    
function predefined_message_selected(id)
{
    if( id )
    {
        save_condition = false;
        
        var message = predefined_messages[id];
        body_field.value = message.body;
        body_field.readOnly = 'readonly';
        if( subject_field )
        {
            subject_field.value = message.subject;
            subject_field.readOnly = 'readonly';
        }
    } else {
        //save_condition = true;
        
        body_field.value = null;
        body_field.readOnly = null;
        
        if( subject_field )
        {
            subject_field.value = null;
            subject_field.readOnly = null;
            
        }
    }
    
}
</script>