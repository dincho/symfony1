<?php echo observe_field('country', array(
    'success'  => 'updateAdm1(request, json)',
    'url'      => 'ajax/getAdm1ByCountry',
    'with'     => "'country=' + value",
)) ?>

<?php echo observe_field('adm1_id', array(
    'success'  => 'updateAdm2(request, json)',
    'url'      => 'ajax/getAdm2ByAdm1',
    'with'     => "'adm1=' + value",
)) ?>

<?php echo javascript_tag("
function updateAdm1(request, json)
{
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm1_id');
  S.options.length = 0;  
  
  if( nbElementsInResponse > 0 )
  {
      S.options[0] = new Option('Please Select', '');
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i] = new Option(json[i-1].title, json[i-1].id);
      }
  }
  
  $('adm2_id').options.length=0;
  clearCity();
}
") ?>

<?php echo javascript_tag("
function updateAdm2(request, json)
{
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm2_id');
  S.options.length = 0;  
  
  if( nbElementsInResponse > 0 )
  {
      S.options[0] = new Option('Please Select', '');
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i] = new Option(json[i-1].title, json[i-1].id);
      }
  }
  clearCity();
}
") ?>

<?php echo javascript_tag("
function clearCity()
{
  var C = $('city');
  C.setAttribute('value', '');
  C.value = '';
}
") ?>