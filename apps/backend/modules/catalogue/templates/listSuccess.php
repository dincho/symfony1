<div class="filter_right"><?php echo button_to ('Add Catalogue', 'catalogue/create') ?></div>
<table class="zebra">
    <thead>
    <tr>
      <th>Language</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($catalogues as $catalogue): ?>
    <tr>
          <td><?php echo $catalogue ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

