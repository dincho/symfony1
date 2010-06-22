<?php use_helper('Catalog'); ?>

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
                <?php echo select_catalog2url(null, 'content/regJoinNow', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Registration</td>
              <td>
                <?php echo select_catalog2url(null, 'content/regReg', null, array('include_custom' => '---')); ?>                
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Self-Description</td>
              <td>
                <?php echo select_catalog2url(null, 'content/regSelf', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td>Essay</td>
              <td>
                <?php echo select_catalog2url(null, 'content/regEssay', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td>Photos</td>
              <td>
                <?php echo select_catalog2url(null, 'content/regPhotos', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
            <tr>
              <td>6</td>
              <td>Search Criteria</td>
              <td>
                <?php echo select_catalog2url(null, 'content/regSearch', null, array('include_custom' => '---')); ?>
              </td>
            </tr>
        </tbody>
</table>
