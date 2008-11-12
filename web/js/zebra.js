// this function is needed to work around 
// a bug in IE related to element attributes
function hasClass(obj) {
   var result = false;
   if (obj.getAttributeNode("class") != null) {
       result = obj.getAttributeNode("class").value;
   }
   return result;
}

/* param table => table reference */
function stripe(table) {

   // the flag we'll use to keep track of 
   // whether the current row is odd or even
   var even = false;
 
   // if arguments are provided to specify the colours
   // of the even & odd rows, then use the them;
   // otherwise use the following defaults:
   var evenColor = arguments[1] ? arguments[1] : "#eee";
   var oddColor = arguments[2] ? arguments[2] : "#fff";
 
   // obtain a reference to the desired table
   // if no such table exists, abort
   //var table = document.getElementById(id);
   if (! table) { return; }
   
   // by definition, tables can have more than one tbody
   // element, so we'll have to get the list of child
   // &lt;tbody&gt;s 
   var tbodies = table.getElementsByTagName("tbody");

   // and iterate through them...
   for (var h = 0; h < tbodies.length; h++) {
   
    // find all the &lt;tr&gt; elements... 
     var trs = tbodies[h].getElementsByTagName("tr");
     
     // ... and iterate through them
     for (var i = 0; i < trs.length; i++) {

       // avoid rows that have a class attribute
       // or backgroundColor style
       if ( ! trs[i].style.backgroundColor) {
     
         if( trs[i].getAttribute('rel') )
         {
	         // get all the cells in this row...
	         var tds = trs[i].getElementsByTagName("td");
	         var remote_function = (hasClass(trs[i]) == 'remote_function') ? true : false;
	         var the_rel = trs[i].getAttribute('rel');
	         
	         // and iterate through them...
	         for (var j = 0; j < tds.length; j++) {
	       
	           var mytd = tds[j];
	
	           // avoid cells that have a class attribute
	           // or backgroundColor style
	           if (! hasClass(mytd) &&
	               ! mytd.onclick) {
	              
	              if( remote_function ) 
	              {
	                mytd.onclick = function() { eval(this.parentNode.getAttribute('rel')); return false; };
	              } else {
	                mytd.onclick = function(){ window.location.href= this.parentNode.getAttribute('rel'); return false;};
	              }
	           }
	         }
	       }
			if( even ) {
			    if( trs[i].className )
			    {
			        trs[i].className = trs[i].className + " even";
			    } else {
			        trs[i].className = 'even';
			    }
			}
       }
       // flip from odd to even, or vice-versa
       even =  ! even;
     }
   }
 }

function zebra() {  
	contentDiv = document.getElementById('content');
	tables = contentDiv.getElementsByTagName("table");
	
	for(var t = 0; t < tables.length; t++) {
	  if( tables[t].className == 'zebra') stripe(tables[t]);
	}
}

window.onload = zebra;