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
    
   function disable_button(button)
   {
     $(button).className = "button_disabled";
     $(button).onclick = function(){return false;};
   }

   function enable_button(button)
   {
     $(button).className = "button";
     $(button).onclick = function(){ save_draft(); return false;};
   }

   function save_complete()
   {
       $("save_to_draft_btn").blur();
       $("save_to_draft_btn").value = "'. __('Saved') .'";
       disable_button("save_to_draft_btn");
       save_condition = false;
       if( last_focused_field ) last_focused_field.focus();
   }

   function enable_saving()
   {
       $("save_to_draft_btn").value = "'. __('Save Now') .'";
       enable_button("save_to_draft_btn");
       save_condition = true;
   }
    
    Event.observe("title", "keypress", function(event){ enable_saving(); $("title").focus(); });
    Event.observe("title", "focus", function(event){ last_focused_field = $("title"); });
    
    Event.observe("your_story", "keypress", function(event){ enable_saving(); $("your_story").focus(); });
    Event.observe("your_story", "focus", function(event){ last_focused_field = $("your_story"); });
    
    Event.observe(window, "load", function(){ disable_button("save_to_draft_btn"); });
');?>