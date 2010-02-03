<?php foreach($member->getMemberPhotos() as $i => $photo): ?>
    <?php echo link_to(image_tag( ($photo->getImageFilename('cropped')) ? $photo->getImageUrlPath('cropped', '100x100') : $photo->getImageUrlPath('file', '100x100') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?>
    <?php if( ($i+1)%2 == 0): ?>
        <br />
    <?php endif; ?>
<?php endforeach; ?>