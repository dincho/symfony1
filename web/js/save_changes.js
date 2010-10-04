// JavaScript Document
var hash = new Array();
var ch_hash = new Array();


function checked_item(id, checked)
{
  this.id;
  this.checked;
  
  this.GetId = function() { return id;}
  this.GetChecked = function() { return checked;}
}


function enable_save_btn()
{
   if($("save_btn").disabled)
   {
    $("save_btn").enable();
   }
}

function validate_save_btn()
{
  for(var i=0; i< hash.length; i++)
  {
    if($(hash[i].id).value != hash[i].value )
    {
      $("save_btn").enable();
      return; 
    } 
  }
  for(var i=0; i< ch_hash.length; i++)
  {
    if($(ch_hash[i].GetId().toString()).checked != ch_hash[i].GetChecked() )
    {
      $("save_btn").enable();
      return;
    } 
  }  
  $("save_btn").disable(); 
}

Event.observe(window, 'load',function()
{
  var fields = $$("input", "textarea", "select");
  for (var i = 0; i < fields.length; i++) 
  {
    if(fields[i].type != 'submit' && fields[i].type != 'button' &&
       fields[i].type != 'checkbox' && fields[i].type != 'radio' &&
       fields[i].type != 'hidden' )
    {
      hash.push(Object.clone(fields[i]));
    
      fields[i].observe('keypress', enable_save_btn);
      fields[i].observe('blur', validate_save_btn);
      fields[i].observe('change', validate_save_btn);
      
      
    }
    else if(fields[i].type == 'checkbox' || fields[i].type == 'radio')
    {
      ch_hash.push( new checked_item([fields[i].id], fields[i].checked));  

      fields[i].observe('keypress', validate_save_btn);
      fields[i].observe('click', validate_save_btn);
      fields[i].observe('blur', validate_save_btn);
      fields[i].observe('change', validate_save_btn);
    }  
  }
  
  $("save_btn").disable(); 

});