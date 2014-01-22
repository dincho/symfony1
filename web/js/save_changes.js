// JavaScript Document
var hash = new Array();

function disable_button(button)
{
 $(button).className = 'button_disabled';
 $(button).onclick = function(){return false;};
}

function enable_button(button)
{
 $(button).className = 'button';
 $(button).onclick = null;
}

function checked_item(id, type, value, checked)
{
 this.id;
 this.type;
 this.value;
 this.checked;

 this.getId = function() { return id;}
 this.getType = function() { return type;}
 this.getValue = function() { return value;}
 this.getChecked = function() { return checked;}
}



function validate_save_btn()
{
 disable_button("save_btn");
 for(var i=0; i< hash.length; i++)
 {
   if(hash[i].getType() == 'checkbox' || hash[i].getType() == 'radio')
   {
     if($(hash[i].getId().toString()).checked != hash[i].getChecked() )
     {
       enable_button("save_btn");
       return;
     }
   }
   else
   {
     if($(hash[i].getId().toString()).style.display !='none' &&
$(hash[i].getId().toString()).value != hash[i].getValue() )
     {
       enable_button("save_btn");
       return;
     }
   }
 }
}


Event.observe(window, 'load',function()
{
 disable_button("save_btn");
 var fields = $$("input", "textarea", "select");
 for (var i = 0; i < fields.length; i++)
 {
     hash.push( new checked_item([fields[i].id], fields[i].type,
fields[i].value, fields[i].checked));

     fields[i].observe('keyup', validate_save_btn);
     fields[i].observe('click', validate_save_btn);
     fields[i].observe('blur', validate_save_btn);
     fields[i].observe('change', validate_save_btn);
 }
});