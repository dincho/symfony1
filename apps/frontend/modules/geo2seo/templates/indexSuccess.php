<div id="countries">
    <?php foreach($countries_columns as $column_key => $countries_column): ?>
    <table>
      <?php $p_char = '';$i=1;?>
      <?php foreach ($countries_column as $iso => $name): ?>
          <?php $char = mb_substr($name, 0, 1, 'UTF-8'); ?>
          <?php if( $char != $p_char ): ?>
          <tr>
            <th>
              <span><?php echo $char; $p_char = $char ?></span>
            </th>
          </tr>
          <?php endif; ?>
          <tr>
            <td>
              <?php echo link_to($name, '@country_info?country_iso=' . $iso . '&country_name=' . $name); ?>
            </td>
          </tr>
      <?php endforeach; ?>
    </table>
    <?php endforeach; ?>
    
    <br class="clear" />
</div>