<?php use_helper('Catalog'); ?>

<table class="zebra">
    <thead>
        <tr>
         <th width="20px">Pages</th>
         <th width="150px">Name</th>
         <th>Catalog</th>
        </tr>
    </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>Most Recent</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchMostRecent', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Custom (by Criteria)</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchCustom', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Reverse</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchReverse', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Matches</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchMatches', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>By Keyword</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchKeyword', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>Profile ID</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchProfileId', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>Public Search</td>
              <td>
                <?php echo select_catalog2url(null, 'content/searchPublic', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
        </tbody>
</table>
