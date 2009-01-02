<?php use_helper('I18N') ?>
<table class="zebra">
    <thead>
        <tr>
         <th>Profile Page</th>
         <th>Language</th>
        </tr>
    </thead>
        <tbody>
            <tr>
              <td>Profile</td>
              <td>
                <?php echo link_to(image_tag('flags/us.gif'), 'content/profilepage?culture=en') ?>
                <?php echo link_to(image_tag('flags/pl.gif'), 'content/profilepage?culture=pl') ?>
              </td>
            </tr>
        </tbody>
</table>
