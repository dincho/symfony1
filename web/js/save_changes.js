// JavaScript Document
var hash = new Array();


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
  for(var i=0; i< hash.length; i++)
  {
    if(hash[i].getType() == 'checkbox' || hash[i].getType() == 'radio')
    {
      if($(hash[i].getId().toString()).checked != hash[i].getChecked() )
      {
        $("save_btn").enable();
        return; 
      }
    }
    else
    {
      if($(hash[i].getId().toString()).style.display !='none' && $(hash[i].getId().toString()).value != hash[i].getValue() )
      {
        $("save_btn").enable();
        return;
      } 
    }
  }
  $("save_btn").disable();
}


Event.observe(window, 'load',function()
{
  $("save_btn").disable(); 
  var fields = $$("input", "textarea", "select");
  for (var i = 0; i < fields.length; i++) 
  {
      hash.push( new checked_item([fields[i].id], fields[i].type, fields[i].value, fields[i].checked));  

      fields[i].observe('keypress', validate_save_btn);
      fields[i].observe('click', validate_save_btn);
      fields[i].observe('blur', validate_save_btn);
      fields[i].observe('change', validate_save_btn);
  }
});