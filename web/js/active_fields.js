Event.observe(window, 'load', function() {
  var fields = $$("input", "textarea", "select");
  for (var i = 0; i < fields.length; i++) {
    if( fields[i].type != 'submit' && fields[i].type != 'button')
    {
        fields[i].onfocus = function()
        {
            this.className += ' focused';
            if(typeof global_focus_func == 'function') {
                global_focus_func(this);
            }         
        }
        fields[i].onblur = function()
        {
            this.className = this.className.replace('focused', '');
        
            if(typeof global_focus_func == 'function') {
                global_focus_func(this, true);
            }         
        }
    }
  }
});