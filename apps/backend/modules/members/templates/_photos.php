<?php foreach($member->getPublicMemberPhotos() as $i => $photo): ?>
    <?php echo link_to(image_tag( $photo->getImg('50x50') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?>
    <?php if( ($i+1)%4 == 0): ?>
        <br />
    <?php endif; ?>
<?php endforeach; ?>
<hr />
<?php foreach($member->getPrivateMemberPhotos() as $i => $photo): ?>
    <?php echo link_to(image_tag( $photo->getImg('50x50') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?>
    <?php if( ($i+1)%4 == 0): ?>
        <br />
    <?php endif; ?>
<?php endforeach; ?>