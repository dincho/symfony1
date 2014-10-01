<div class="status">
    <?php if( $photo->getAuth() == 'A'): ?>
        Approved -
        <?php echo link_to('Deny', 'members/verifyPhoto?auth=D&id=' . $photo->getMemberId() . '&photo_id='.$photo->getId()); ?>
    <?php elseif($photo->getAuth() == 'D'): ?>
        Denied -
        <?php echo link_to('Approve', 'members/verifyPhoto?auth=A&id=' . $photo->getMemberId() . '&photo_id='.$photo->getId()); ?>
    <?php elseif($photo->getAuth() == 'S'): ?>
        Request -
        <?php echo link_to('Approve', 'members/verifyPhoto?auth=A&id=' . $photo->getMemberId() . '&photo_id='.$photo->getId()) .
                            '&nbsp|&nbsp;'. link_to('Deny', 'members/verifyPhoto?auth=D&id=' . $photo->getMemberId() . '&photo_id='.$photo->getId() ); ?>
    <?php endif; ?>
</div>
