<table class="zebra">
    <thead>
        <tr>
         <th width="50px">Sign Up</th>
         <th width="150px">Name</th>
         <th>Language</th>
        </tr>
    </thead>
        <tbody>
            <tr>
              <td>1</td>
              <td>Join Now</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regJoinNow?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regJoinNow?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Registration</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regReg?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regReg?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Self-Description</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regSelf?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regSelf?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Essay</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regEssay?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regEssay?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>Photos</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regPhotos?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regPhotos?culture=pl') ?>
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>Search Criteria</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/regSearch?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/regSearch?culture=pl') ?>
              </td>
            </tr>
        </tbody>
</table>
