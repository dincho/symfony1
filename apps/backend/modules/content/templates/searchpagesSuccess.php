<table class="zebra">
    <thead>
        <tr>
         <th width="20px">Pages</th>
         <th width="150px">Name</th>
         <th>Language</th>
        </tr>
    </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>Most Recent</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchMostRecent?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchMostRecent?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Custom (by Criteria)</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchCustom?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchCustom?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Reverse</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchReverse?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchReverse?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Matches</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchMatches?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchMatches?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>By Keyword</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchKeyword?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchKeyword?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>Profile ID</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchProfileId?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchProfileId?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>7</td>
              <td>Public Search</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/searchPublic?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/searchPublic?culture=pl') ?>
              </td>
            </tr>
        </tbody>
</table>
