<?php use_helper('Object', 'dtForm', 'I18N', 'Javascript') ?>

<?php include_component('system', 'formErrors') ?>

  <div class="legend">View Areas of Country: <?php echo format_country($country) ?></div>
  <fieldset class="form_fields" id="states_fieldset">
    
    <label for="country">Country:</label>
    <?php echo select_country_tag('country', $country, array('onchange' => "document.location.href = '". url_for('areas/view/') ."/country/' + this.value;")) ?>
  
    <table class="zebra">
        <thead>
            <tr>
                <th>Areas</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($adm1s as $adm1): ?> 
            <tr rel="<?php echo url_for('areas/info?id=' . $adm1->getId()) ?>">
                <td><?php echo $adm1->getName(); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
  </fieldset> 
