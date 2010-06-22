<?php use_helper('I18N') ?>
<table class="zebra">
    <thead>
        <tr>
          <th>Catalog</th>
        </tr>
    </thead>
        <tbody>
              <?php foreach($catalogues as $catalog): ?>
                <tr rel="<?php echo url_for('content/profilepage?cat_id=' . $catalog->getCatId()) ?>">
                  <td>
                    <?php echo $catalog; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
        </tbody>
</table>
