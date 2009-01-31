Event.observe(window, 'load', function() {
  var fields = $$("input");
  for (var i = 0; i < fields.length; i++) {
    fields[i].onfocus = function() {this.className += ' focused';}
    fields[i].onblur = function() {this.className = this.className.replace('focused', '');}
  }
});