
<?php echo observe_field('country', array(
    'success'  => 'updateAdm1(request)',
    'url'      => 'ajax/getAdm1ByCountry',
    'with'     => "'country=' + this.getValue()",
    'loading'  => "$('create_feature_form').disable(); $('adm1').options.length = 0; $('adm2').options.length = 0;",
    'complete' => "$('create_feature_form').enable();"
)) ?>

<?php echo observe_field('adm1', array(
    'success'  => 'updateAdm2(request)',
    'url'      => 'ajax/getAdm2ByAdm1Id',
    'with'     => "'country='+$('country').getValue()+'&adm1=' + this.getValue() ",
    'loading'  => "$('create_feature_form').disable(); $('adm2').options.length = 0;",
    'complete' => "$('create_feature_form').enable();"
)) ?>

<?php echo javascript_tag("
function updateAdm1(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm1');
  S.options.length = 0;

  S.options[0] = new Option('', '');
  S.options[0].selected = true;
  for (var i = 1; i <= nbElementsInResponse; i++) {
     S.options[i] = new Option(json[i-1].title, json[i-1].id);
  }
}
") ?>

<?php echo javascript_tag("
function updateAdm2(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm2');
  S.options.length = 0;

  S.options[0] = new Option('', '');
  S.options[0].selected = true;
  for (var i = 1; i <= nbElementsInResponse; i++) {
     S.options[i] = new Option(json[i-1].title, json[i-1].id);
  }
}
") ?>
