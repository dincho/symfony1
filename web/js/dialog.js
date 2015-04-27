/*! 
	Dialog v0
	Copyright (c) 2015 yusaf
	https://github.com/yusaf/dialog.js/blob/gh-pages/LICENSE
*/
(function (document) {
	
	// The use of single is to implement uniformity in the id of dialogs and the parent element.
	// specifying a single id for all dialogs is OK as there should only be one instance of the element present in the DOM.
	//This can however break when using a new Dialog() object however should be handled by the developer using the .toggle() method to remove/add existing dialogs to the DOM.
	var first = false;
	var single = {
		id:{
			def:"dlg",
			set:false
		},
		parent:{
			def:document.body,
			set:false
		},
		keys:[]
	};
	
	//typeof alernative largely for the purpose of precisely destinguishing between {}, [] and null
	function typeOf(obj, objType){ 
		return Object.prototype.toString.call(obj).replace(/^\[object (.+)\]$/, "$1").toLowerCase()===objType;
	}
	
	//This allows for data obtained from previous dialogs to be used in the future.
	function getString(t, string){
		if(typeOf(string, "string")){
			return string;
		}
		else if(typeOf(string, "function")) {
			return string.call(t)+"";
		}
		return "";
	}
	//A simple extend function for extending default values.
	function extend(obj1, obj2) {
		for (var key in obj2) {
			if (typeOf(obj2[key], "object")) {
				obj1[key] = extend(obj1[key], obj2[key]);
			} 
			else {
				obj1[key] = obj2[key];
			}
		}
		return obj1;
	}
	//event listener with fallback for IE8 support
	function on(el, eventName, handler) {
		if (el.addEventListener) {
			el.addEventListener(eventName, handler);
		} 
		else {
			el.attachEvent('on' + eventName, handler);
		}
		return el;
	}
	//diabling event listener with fallback for IE8 support
	function off(el, eventName, handler) {
		if (el.removeEventListener){
			el.removeEventListener(eventName, handler);
		}
		else{
			el.detachEvent('on' + eventName, handler);
		}
		return el;
	}
	//keeping code clean prevent bubbling up in the DOM with IE8 support
	function stopProp(event){	
		if (event.stopPropagation) { 
			event.stopPropagation(); 
		} 
		else { 
			event.cancelBubble  = true; 
		}
		return event;
	}
	//translating keys pressed into clicking corresposing buttons when dialog is present in the DOM.
	on(document.body, "keyup", function(event){
		stopProp(event);
		var 
		code = (event.keyCode ? event.keyCode : event.which),
		overlay = document.getElementById(single.id.def);
		if(overlay && single.keys.indexOf(code) > -1){
			var nextInQueue = overlay.DialogInstance.Q[0];
			if(nextInQueue.buttons){
				for(var key in nextInQueue.buttons){
					if(nextInQueue.buttons[key].keys && nextInQueue.buttons[key].keys.indexOf(code) > -1){
						nextInQueue.buttons[key].button.click();
					}
				}
			}
		}
		
		return;		
	});
	
	//handling button clicked events and callbacks.
	//skipping to the next in the queue unless it's been halted.
	function buttonClicked(event){	
		stopProp(event);
		var 
		target = event.target || event.srcElement,
		$this = document.getElementById(single.id.def).DialogInstance;
		nextinQueue = $this.Q[0];
		
		
		var buttonPressedData = (target.className !== "dlg-x" ? nextinQueue.buttons[target.innerHTML] : "");
		if(nextinQueue.callback){
			if(target.className === "dlg-x"){				
				nextinQueue.callback.call($this, null );				
			}
			else if(typeof nextinQueue.value !== "undefined" ){
				nextinQueue.callback.call($this,  ( buttonPressedData.call ? $this.dialog.querySelector("input").value : null ) );
			}
			else{
				nextinQueue.callback.call($this,  buttonPressedData.call  );
			}
		}
		if(buttonPressedData && buttonPressedData.inactive){
			return;			
		}
		if(!$this.halt){
			$this.skipQ();
		}
		if($this){
			$this.halt = false;
		}
		return ;
	}
	
	//focusing input and selecting defaults values of input.
	function focusIt(input){
	if(input.value.length && input.setSelectionRange){
		input.setSelectionRange(0, input.value.length);
	}
	input.focus();
}



function Dialog(data){
	
	data = extend({
		className:"",
		//Do Not Extend Below Properties
		dialog:null,
		Q:[],
		data:{}
	}, data||{});
	
	var $this = this;	
	//if defaults for parent haven't already been set, set them!
	for(var key in data){
		if(!first && single[key]){
			first = true;
			if(!single[key].set){
				single[key].def = getString($this, data[key]);
				single[key].set = true;
			}	
			continue;
		}
		$this[key] = data[key];
	}
}

Dialog.prototype = {
	// use functions elsewhere in code.
	fn:{
		//for plugins, use Dialog.prototype.fn.extend(Dialog.prototype, { myPlugin:function(){ } })
		extend:extend
	},
	
	custom:function(data){
		var $this = this;
		
		// if data is present add it to the queue
		if(data){
			$this.Q.push(data);
		}
		//if it is the end of the queue and .Qend(callback) has been used callback will be called
		if(!$this.Q.length && $this.queueEnd){
			$this.queueEnd.call($this);
		}
		//if there is still data in the queue and there is no dialog
		if($this.Q.length && $this.dialog === null){
			//crete the dialog element
			$this.dialog  = document.createElement("div");
			//next in queue is the first index of the array
			var nextinQueue = $this.Q[0],
			dialog = $this.dialog;
			//toggling the dialog to add it to the DOM
			$this.inParent = false;					
			$this.toggle();
			dialog.id = single.id.def;
			if($this.className || nextinQueue.className){
				dialog.className = (getString($this, $this.className) + " " + getString($this, nextinQueue.className||"")).replace(/\s+/gi," ");
			}
			//adding the DialogInstance property to the element for use in the buttonClicked function for referencing to this specific object
			dialog.DialogInstance = $this;
			
			
			dialog.innerHTML  += ''
			+'<div class="dlg-box'+ (nextinQueue.buttons ? "" : " dlg-empty") + '">'
			+'<div class="dlg-hdr">'
			+'<span>'
			+( nextinQueue.header ? getString($this, nextinQueue.header) : "" )
			+'</span>'
			//settubg noClose to true will remove the close button
			+( nextinQueue.noClose ? "" : '<div class="dlg-x">X</div>' )
			+'</div>'
			+'<div class="dlg-bdy">'
			+( nextinQueue.body ? getString($this, nextinQueue.body) : "" )
			+( typeof nextinQueue.value !== "undefined" ? '<input type="text" value="'+getString($this, nextinQueue.value)+'">' : "" )
			+'</div>'
			+'<div class="dlg-ftr">'
			+'</div>'
			+'</div>';
			//if the dialog even has buttons
			if(nextinQueue.buttons){
				var footer = dialog.querySelector(".dlg-ftr");
				for(var key in nextinQueue.buttons){
					//create a button
					var button = document.createElement("button"),
					//tidying up the data for uniformity in the buttonClicked function.
					buttonData = nextinQueue.buttons[key];
					if(!typeOf(buttonData, "object")){
						buttonData = {
							call:buttonData
						};
					}
					buttonData = extend({
						button:button,
						inactive:false,
						className:"",
						call:key
					}, buttonData);
					if(buttonData.keys){
						if(typeOf(buttonData.keys, "number")) buttonData.keys = [buttonData.keys];
						for(var i = 0; i < buttonData.keys.length; i++){
							single.keys.push(buttonData.keys[i]);
						}
					}
					nextinQueue.buttons[key] = buttonData;
					
					footer.appendChild(button);
					if(buttonData.className){
						button.className = getString($this, buttonData.className);
					}
					button.innerHTML = key;
					on(button, "click", buttonClicked);
				}
			}
			if(!nextinQueue.noClose){
				on(dialog.querySelector(".dlg-x"), "click", buttonClicked);
			}
			var input = dialog.querySelector("input");
			if(input){
				focusIt(input);
			}
			if(nextinQueue.active){
				nextinQueue.active.call( $this );
			}
			if($this.active){
				$this.active.call( $this );
			}
		}
		return this;
	},
	
	toggle:function(){
		// toggling by adding/removing element from DOM
		var $this = this,
		dialog = $this.dialog;
		if($this.inParent){
			single.parent.def.removeChild(dialog);
			$this.inParent = false;
		}
		else{
			$this.inParent = true;
			single.parent.def.appendChild(dialog);
			var input = dialog.querySelector("input");
			if(input){
				focusIt(input);
			}
		}
		return $this;
	},
	//can set object.halt = true, however chaining allows  for simplicity.
	pauseQ:function(){
		var $this = this;
		$this.halt = true;
		return $this;
	},
	//remove the current dialog and continue to next in the queue 
	skipQ:function(){
		var $this = this;
		if($this.dialog){
			var buttons = $this.dialog.querySelectorAll(".dlg-ftr button");
			for(var i = 0; i < buttons.length; i++){
				off(buttons[i], "click", buttonClicked);					
			}
			if(!$this.Q[0].noClose){
				off($this.dialog.querySelector(".dlg-x"), "click", buttonClicked);
			}
			$this.Q.splice(0, 1);
			if($this.inParent){
				$this.toggle();
			}
			$this.dialog = null;
			$this.custom();
		}
		return $this;
	},
	//remove all but the current dialog from the queue
	stopQ:function(){
		var $this = this;
		$this.Q = [$this.Q[0]];
		return $this;
	},
	//callback for when the queue has depleted
	Qend:function(callback){
		var $this = this;
		$this.queueEnd = callback;
		return $this;
	},
	
	alert:function(header){
		
		return this.custom({
			header:header,
			buttons:{
				"OK":{
					call:true,
					keys:[13,27]
				}
			}
		});	
		
	},
	
	confirm: function(header, callback){
		
		return this.custom({
			header:header,
			buttons:{
				"OK":{
					call:true,
					keys:13
				},
				"Cancel":{
					call:false,
					keys:27
				}
			},
			callback: callback
		});
		
	},		
	
	prompt: function(header, defaultValue, callback){
		
		return this.custom({
			header:header,
			buttons:{
				"OK":{
					call:true,
					keys:13
				},
				"Cancel":{
					call:null,
					keys:27
				}
			},
			value:( typeOf(defaultValue, "string")  ? defaultValue : ( ( typeOf(defaultValue, "function") && (typeof callback !== "undefined" ) ) ? defaultValue : "" ) ),
			callback: callback || defaultValue
		});
		
	}	
	
};

window.Dialog = Dialog;

})(document);