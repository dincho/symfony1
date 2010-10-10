// JavaScript Document


var table1 = null;


Event.observe(window, 'load', function()
{
  table1 = new table.SelectableTable("table1", true);
});

var table = {};

table.keys = {
  AddNew : function(id,action){
    this.monitorActions[id] = action;
  },
  monitorActions : new Array()
 }

table.ActiveTable = null;

table.SelectableTable = function(tableId,activate){
  var ref = this;
  this.tableId = tableId; 
  this._init();
  this.selectedId = null;
  table.keys.AddNew(tableId,ref);
  if(activate){
   table.ActiveTable = tableId;
   this.selectFirst();
  }
}


table.SelectableTable.prototype._init = function(){
  var rows = $$('#'+this.tableId +' tr');
  var cnt = rows.length;
  for(var i=0; i<cnt;i++){
    rows[i].defaultClassName = rows[i].className;            
  }
}

table.SelectableTable.prototype.selectFirst = function(){

  var firstRow = $$('#'+this.tableId +' tr')[1];
  firstRow.className = "selected"
  this.selectedId = firstRow.id;
  $($$('#'+this.tableId +' tr input')[1]).click();
}

table.SelectableTable.prototype.keyClick = function(keyCode){
  var direction = (keyCode==37 || keyCode==38)?-1:(keyCode==39 || keyCode==40)?1:0;
  if(direction!=0){
    this.selectNext(direction);
  }
}

table.SelectableTable.prototype.selectNext = function(dir){
  
  var rows = $$('#'+this.tableId +' tr');
  var inputs = $$('#'+this.tableId +' tr input');
  var cnt = rows.length;
  var hasSelection = false;
  for(var i=1; i<cnt;i++){
    if(rows[i].className == "selected"){
      if((dir==-1 && i>1) || (dir==1 && i+1<cnt)){
        rows[i].className = rows[i].defaultClassName;
        rows[i+dir].className = "selected";
        this.selectedId = rows[i+dir].id;
        $(inputs[i-1+dir].id).click();
      }
      hasSelection = true;
      break;
    }
  }
}

function go_to_page(page)
{
  var links = $$('#pager a');
  links.each(function(elem){
   if (elem.innerHTML == page)
   {
      window.location.href=elem; 
   }
  });
}

function handleKeyPress(e){
  var keycode;
  if (window.event) keycode = window.event.keyCode;
  else if (e) keycode = e.which;
  if (keycode==33) //pageup
  {
    go_to_page('Previous');
  }
  else if(keycode==34) //pagedown
  {
    go_to_page('Next');  
  }
  else if(keycode==36) //home
  {
    go_to_page('First');  
  }
  else if(keycode==35) //end
  {
    go_to_page('Last');  
  }
  if(table.ActiveTable){
     table.keys.monitorActions[table.ActiveTable].keyClick(keycode);
  }
}

document.onkeydown = handleKeyPress;
