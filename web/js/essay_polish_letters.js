var active_field;

function global_focus_func(obj, blur)
{
	if( !blur )
	{
		active_field = obj;
	}
}

function pl_letter_press(letter)
{
	if( active_field )
	{
	    var value = active_field.value.replace(/\u000d\u000a/g,'\u000a').replace(/\u000a/g,'\u000d\u000a');
	    
		if( value.length < active_field.getAttribute("maxlength") )
		{
			if( document.selection )
			{
				active_field.focus();
				document.selection.createRange().text = letter;
			}
			else if(active_field.selectionStart || active_field.selectionStart == '0')
			{
				var stb = active_field.value.substring(0,active_field.selectionStart);
				var ste = active_field.value.substring(active_field.selectionEnd,active_field.value.length);
				active_field.value = stb + letter + ste;
				active_field.focus();
			}
			else
			{
				active_field.value += letter;
			}
			
			if( active_field.type == "textarea" ) displayCharCounts(active_field);
		}
	}
}