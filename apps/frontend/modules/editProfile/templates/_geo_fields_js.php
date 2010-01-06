<?php echo observe_field('country', array(
    'success'  => 'updateAdm1(request)',
    'url'      => 'ajax/getAdm1ByCountry',
    'with'     => "'country=' + value",
    'loading'  => "$('adm2_id').options.length = 0; $('city_id').options.length = 0;"
)) ?>

<?php echo observe_field('adm1_id', array(
    'success'  => 'updateAdm2(request)',
    'url'      => 'ajax/getAdm2ByAdm1Id',
    'with'     => "'country='+$('country').getValue()+'&adm1=' + this.getValue() ",        
    'loading'  => "$('city_id').options.length = 0;"
)) ?>

<?php echo observe_field('adm2_id', array(
    'success'  => 'updateCities(request)',
    'url'      => 'ajax/getCities',
    'with'     => "'country=' + $('country').value + '&adm1_id=' + $('adm1_id').value + '&adm2_id=' + value",
)) ?>

<?php echo javascript_tag("
function updateAdm1(request)
{
  var json = eval('(' + request.responseText + ')');    
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm1_id');
  S.options.length = 0;  
  
  if( nbElementsInResponse > 0 )
  {
      $('adm1_container').style.display = '';
      
      S.options[0] = new Option('".__('Please Select')."', '');
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i] = new Option(json[i-1].title, json[i-1].id);
      }
  } else {
    $('adm1_container').style.display = 'none';
    $('adm2_container').style.display = 'none';
    
    //not int, int is used for grouping of this field
    if( $('country').value.toString().search(/^-?[0-9]+$/) != 0 )
    {
      " . remote_function(array('success' => 'updateCities(request, json)', 
                                'url' => 'ajax/getCities',
                                'with'     => "'country=' + $('country').value",
                                )
                          )
      . "
    }
  }
  
}
") ?>

<?php echo javascript_tag("
function updateAdm2(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('adm2_id');
  S.options.length = 0;
  
  if( nbElementsInResponse > 0 )
  {
    $('adm2_container').style.display = '';
    
      S.options[0] = new Option('".__('Please Select')."', '');
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i] = new Option(json[i-1].title, json[i-1].id);
      }
      

  } else {
    $('adm2_container').style.display = 'none';
    
    if( $('adm1_id').value != '' ) //is not 'please select'
    {
      " . remote_function(array('success' => 'updateCities(request, json)', 
                                'url' => 'ajax/getCities',
                                'with'     => "'country=' + $('country').value + '&adm1_id=' + $('adm1_id').value",
                                )
                          )
      . "    
    }
  }
  
}
") ?>

<?php echo javascript_tag("
function updateCities(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('city_id');
  S.options.length = 0;  
  
  if( nbElementsInResponse > 0 )
  {
      S.options[0] = new Option('".__('Please Select')."', '');
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i] = new Option(json[i-1].title, json[i-1].id);
      }
  }
  
}
") ?>
