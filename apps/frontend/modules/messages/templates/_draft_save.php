<?php $remote_options = array('url'       => 'ajax/SaveToDraft?draft_id='.$draft->getId(),
                            'with'      => "'content=' + escape(\$F('your_story')) + '&subject=' + escape(\$F('title'))",
                            'update'    => 'feedback',
                            'complete'  => 'save_complete(); ',
                            'condition' => 'save_condition',
                            'loading'   => '$("save_to_draft_btn").value = "'. __('Saving...') .'"',
    );
?>

<?php echo periodically_call_remote(array_merge($remote_options, array('frequency' => 60))); ?>

<?php echo javascript_tag('

    var save_condition = false;
    var last_focused_field = null;
    
    function save_draft()
    {
        '. remote_function($remote_options) .'
    }
    
    function save_complete()
    {
        $("save_to_draft_btn").blur(); 
        $("save_to_draft_btn").value = "'. __('Saved') .'";
        $("save_to_draft_btn").disable(); 
        save_condition = false;
        if( last_focused_field ) last_focused_field.focus();
    }
    
    function enable_saving()
    {
        $("save_to_draft_btn").value = "'. __('Save Now') .'";
        $("save_to_draft_btn").enable();
        save_condition = true;
    }
    
    Event.observe("title", "keypress", function(event){ enable_saving(); $("title").focus(); });
    Event.observe("title", "focus", function(event){ last_focused_field = $("title"); });
    
    Event.observe("your_story", "keypress", function(event){ enable_saving(); $("your_story").focus(); });
    Event.observe("your_story", "focus", function(event){ last_focused_field = $("your_story"); });
');?>