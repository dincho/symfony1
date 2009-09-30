/*
If you want to use this script, please keep the original author in this header!

Purpose:    Script for applying maxlengths to textareas and monitoring their character lengths.
Author:     James O'Cull
Date:       08/14/08

Modified: Dincho Todorov
Modified: Date 19.11.2008
Note: removed html attributes to not be used, because of xhtml validation
*/
var LabelCounter = 0;

function parseCharCounts()
{
    //Get Everything...
    var elements = document.getElementsByTagName('textarea');
    var element = null;
    var newlabel = null;
    
    for(var i=0; i < elements.length; i++)
    {
        element = elements[i];
        
        //Create new label
        newlabel = document.createElement('label');
        newlabel.id = 'limitlbl_' + LabelCounter;
        newlabel.className = 'char_remaining';
        newlabel.style.color = 'red';
        newlabel.style.display = 'block'; //Make it block so it sits nicely.
        newlabel.innerHTML = "Updating...";
        
        //Attach limiter to our textarea
        element.setAttribute('limiterid', newlabel.id);
        element.onkeyup = function(){ displayCharCounts(this); };
        
        //Append element
        element.parentNode.insertBefore(newlabel, element.nextSibling);
        
        //Force the update now!
        displayCharCounts(element);
        
        //Push up the number
        LabelCounter++;
    }
}

function displayCharCounts(element)
{
    var limitLabel = document.getElementById(element.getAttribute('limiterid'));
    var maxlength = 2500;
    var enforceLength = true;
    if(element.getAttribute('lengthcut') != null && element.getAttribute('lengthcut').toLowerCase() == 'true')
    {
        enforceLength = true;
    }
    
    //Replace \r\n with \n then replace \n with \r\n
    //Can't replace \n with \r\n directly because \r\n will be come \r\r\n

    //We do this because different browsers and servers handle new lines differently.
    //Internet Explorer and Opera say a new line is \r\n
    //Firefox and Safari say a new line is just a \n
    //ASP.NET seems to convert any plain \n characters to \r\n, which leads to counting issues
    var value = element.value.replace(/\u000d\u000a/g,'\u000a').replace(/\u000a/g,'\u000d\u000a');
    var currentLength = value.length;
    var remaining = 0;
    
    if(maxlength == null || limitLabel == null)
    {
        return false;
    }
    remaining = maxlength - currentLength;
    
    if(remaining >= 0)
    {
        limitLabel.style.color = '#92897E';
        limitLabel.innerHTML = '(' + remaining + ' Character';
        if(remaining != 1)
            limitLabel.innerHTML += 's';
        limitLabel.innerHTML += ' remaining)';
    }
    else
    {
        if (enforceLength == true) {
            value = value.substring(0, maxlength);
            element.value = value;
            //element.setSelectionRange(maxlength, maxlength);
            limitLabel.style.color = '#92897E';
            limitLabel.innerHTML = '(0 Characters remaining)';
        }
        else {
            //Non-negative
            remaining = Math.abs(remaining);
            
            limitLabel.style.color = 'red';
            limitLabel.innerHTML = 'Over by ' + remaining + ' character';
            if (remaining != 1) 
                limitLabel.innerHTML += 's';
            limitLabel.innerHTML += '!';
        }
    }
}
