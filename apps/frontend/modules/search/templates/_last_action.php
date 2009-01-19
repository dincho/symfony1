<?php $member = $match->getMemberRelatedByMember2Id(); ?>
<?php if($match->mail == 'SM'): ?>
    <u><?php echo __('You mailed') ?></u>
<?php elseif($match->mail == 'RM'): ?>
    <u class="strong"><?php echo __('%she_he% mailed', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?></u>
<?php elseif($match->wink == 'SW'): ?>
    <u><?php echo __('You winked') ?></u>
<?php elseif($match->wink == 'RW'): ?>
    <u class="strong"><?php echo __('%she_he% winked', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) ?></u>
<?php endif; ?>