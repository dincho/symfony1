<?php use_helper('Number', 'xSortableTitle', 'Object', 'I18N', 'Javascript') ?>

<div id="loading" style="display: none;" class="float-right">Loading please wait ...</div>
<?php $ret_uri = base64_encode(url_for('geo/list?page=' . $pager->getPage() . '&per_page=' . $pager->getMaxPerPage(), array('abosulute' => true))); ?>
<?php echo form_tag('geo/list?filter=filter', array('method' => 'get', 'id' => 'multiple_filter', 'class' => 'filter_multiple')); ?>
    <label for="filters_country">Country:</label>
    <label for="filters_adm1">ADM1:</label>
    <label for="filters_adm2">ADM2:</label>
    <label for="filters_dsg">DSG:</label>
    <label for="filters_name">Name:</label>
    <br />

    <?php echo select_tag('filters[country]', 
                            options_for_select(array('GEO_ALL' => 'All('. count($countries).')', 'GEO_UNASSIGNED' => 'Unassigned'), $filters['country']) . 
                            options_for_select($countries, $filters['country']), 
                            array('multiple' => true)
                        ); ?>

    <?php echo select_tag('filters[adm1]', 
                            options_for_select(array('GEO_ALL' => 'All('. count($adm1s).')', 'GEO_UNASSIGNED' => 'Unassigned'), $filters['adm1']) . 
                            objects_for_select($adm1s, 'getId', 'getName', $filters['adm1']), 
                            array('multiple' => true)
                        ); ?> 
                                        
    <?php echo select_tag('filters[adm2]', 
                            options_for_select(array('GEO_ALL' => 'All('. count($adm2s).')', 'GEO_UNASSIGNED' => 'Unassigned'), $filters['adm2']) . 
                            objects_for_select($adm2s, 'getId', 'getName', $filters['adm2']), 
                            array('multiple' => true)
                        ); ?>
                    
    <?php echo select_tag('filters[dsg]', 
                            options_for_select(array('GEO_ALL' => 'All('. count($DSGs).')', 'GEO_UNASSIGNED' => 'Unassigned'), $filters['dsg']) . 
                            options_for_select($DSGs, $filters['dsg']), 
                            array('multiple' => true)
                        ); ?>
                        
    <?php echo input_tag('filters[name]', $filters['name'], array('style' => 'vertical-align: top', )); ?>
    
    <br />
    <?php echo submit_tag('Apply Filter', array('id' => 'apply_filter')); ?>

</form>

<br /><br />

<div>
    <div class="flaot-right">
        Total Results: <?php echo format_number($pager->getNbResults()) ?>
        <?php echo button_to('Add Feature', 'geo/create?ret_uri=' . $ret_uri) ?>
        <?php echo button_to('Add Country', 'geo/createCountry?ret_uri=' . $ret_uri) ?>
    </div>
    
    <div style="padding-right: 5px;">
            <span>select:</span>
            <?php echo link_to_function('all', '$("geo_list_form").getInputs("checkbox").each(function(e){ if(!e.disabled) e.checked = true });'); ?>
            <?php echo link_to_function('none', '$("geo_list_form").getInputs("checkbox").each(function(e){ if(!e.disabled) e.checked = false });'); ?>
            <?php echo link_to_function('reverse', '$("geo_list_form").getInputs("checkbox").each(function(e){ if(!e.disabled) e.checked = !e.checked });'); ?>
    </div>
    <br />
</div>


<?php echo form_tag('geo/batchEdit', array('method' => 'get', 'id' => 'geo_list_form', )) ?>
    <?php echo input_hidden_tag('ret_uri', $ret_uri); ?>
    <table class="zebra">
      <thead>
        <tr>
          <th></th>
          <th><?php echo sortable_title('ID', 'Geo::id', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Name', 'Geo::name', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Country', 'Geo::country', $sort_namespace) ?></th>
          <th><?php echo sortable_title('ADM1', 'adm1|Geo::name', $sort_namespace) ?></th>
          <th><?php echo sortable_title('ADM2', 'adm2|Geo::name', $sort_namespace) ?></th>
          <th><?php echo sortable_title('DSG', 'Geo::dsg', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Lat', 'Geo::latitude', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Long', 'Geo::longitude', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Timezone', 'Geo::timezone', $sort_namespace) ?></th>
          <th><?php echo sortable_title('Details', 'Geo::geo_details_id', $sort_namespace) ?></th>
        </tr>
      </thead>
      <tbody>
      
      <?php foreach ($pager->getResults() as $geo): ?>
          <?php $edit_uri = ($geo->getDsg() == 'PCL') ? 'geo/editCountry' : 'geo/edit'; ?>
          <tr rel="<?php echo url_for($edit_uri . '?id=' . $geo->getId() . '&ret_uri=' .$ret_uri); ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $geo->getId(), null, array('disabled' => ($geo->getDsg() == 'PCL'), )) ?></td>
            <td><?php echo $geo->getId() ?></td>
            <td><?php echo $geo->getName() ?></td>
            <td><?php echo format_country($geo->getCountry()) ?></td>
            <td><?php echo $geo->getAdm1() ?></td>
            <td><?php echo $geo->getAdm2() ?></td>
            <td><?php echo $geo->getDsg() ?></td>
            <td><?php echo $geo->getLatitude() ?></td>
            <td><?php echo $geo->getLongitude() ?></td>
            <td><?php echo $geo->getTimezone(); ?></td>
            <td class="skip"><?php echo link_to(($geo->getGeoDetailsId() ? 'edit' : 'add'), 'geo/editDetails?id=' . $geo->getId()); ?></td>
          </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="actions">
        <?php echo submit_tag('Batch Edit') ?>
    </div>
</form>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'geo/list')); ?>

<?php echo observe_field('filters_country', array(
    'success'  => 'updateAdm1(request)',
    'url'      => 'ajax/getAdm1ByCountry?allow_blank=1',
    'with'     => "'country=' + this.getValue()",
    'loading'  => "loading(true); $('filters_adm1').options.length = 0; $('filters_adm2').options.length = 0; $('filters_dsg').options.length = 0;",
)) ?>

<?php echo observe_field('filters_adm1', array(
    'success'  => 'updateAdm2(request)',
    'url'      => 'ajax/getAdm2ByAdm1Id?allow_blank=1',
    'with'     => "'country='+$('filters_country').getValue()+'&adm1=' + this.getValue() ",
    'loading'  => "loading(true); $('filters_adm2').options.length = 0; $('filters_dsg').options.length = 0;",
)) ?>

<?php echo observe_field('filters_adm2', array(
    'success'  => 'updateDSG(request)',
    'url'      => 'ajax/getDSG',
    'with'     => "'country='+$('filters_country').getValue()+'&adm1=' + $('filters_adm1').getValue()+'&adm2=' + this.getValue() ",
    'loading'  => "loading(); $('filters_dsg').options.length = 0;",
)) ?>

<?php echo javascript_tag("
function loading(start)
{
    if( start )
    {
        $('loading').show();
        $('multiple_filter').disable();
    } else {
        $('multiple_filter').enable();
        $('loading').hide();
    }
}

");
?>

<?php echo javascript_tag("
function updateAdm1(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('filters_adm1');
  S.options.length = 0;  
  
      S.options[0] = new Option('All('+nbElementsInResponse+')', 'GEO_ALL');
      S.options[0].selected = true;
      S.options[1] = new Option('Unassigned', 'GEO_UNASSIGNED');
      
      for (var i = 1; i <= nbElementsInResponse; i++)
      {
         S.options[i+1] = new Option(json[i-1].title, json[i-1].id);
      }
      
      " . remote_function(array('success' => 'updateAdm2(request)', 
                                'url' => 'ajax/getAdm2ByAdm1Id?allow_blank=1',
                                'with'     => "'country='+$('filters_country').getValue()+'&adm1=' + $('filters_adm1').getValue()",
                                )
                          )
      . "  
}
") ?>

<?php echo javascript_tag("
function updateAdm2(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('filters_adm2');
  S.options.length = 0;  
  
  S.options[0] = new Option('All('+nbElementsInResponse+')', 'GEO_ALL');
  S.options[0].selected = true;
  S.options[1] = new Option('Unassigned', 'GEO_UNASSIGNED');
  
  for (var i = 1; i <= nbElementsInResponse; i++)
  {
     S.options[i+1] = new Option(json[i-1].title, json[i-1].id);
  }
  
  " . remote_function(array('success' => 'updateDSG(request)', 
                            'url' => 'ajax/getDSG',
                            'with'     => "'country='+$('filters_country').getValue()+'&adm1=' + $('filters_adm1').getValue()+'&adm2=' + $('filters_adm2').getValue()",
                            )
                      )
  . "          
  
}
") ?>

<?php echo javascript_tag("
function updateDSG(request)
{
  var json = eval('(' + request.responseText + ')');
  var nbElementsInResponse = (json) ? json.length : 0;
  var S = $('filters_dsg');
  S.options.length = 0;
  
  S.options[0] = new Option('All('+nbElementsInResponse+')', 'GEO_ALL');
  S.options[0].selected = true;
  S.options[1] = new Option('Unassigned', 'GEO_UNASSIGNED');
  
  for (var i = 1; i <= nbElementsInResponse; i++)
  {
     S.options[i+1] = new Option(json[i-1], json[i-1]);
  }
  
  loading(false);
}
") ?>
