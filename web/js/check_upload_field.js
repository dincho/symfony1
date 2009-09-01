var save_button = true;

function check_upload_field(confirm_msg)
{
  if( save_button && document.getElementById("new_photo").value.length > 0 ) 
  {
    return confirm(confirm_msg);
  }
  
  save_button = true;
  
  return true;
}