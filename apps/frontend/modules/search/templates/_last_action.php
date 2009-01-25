<?php $member = $match->getMemberRelatedByMember2Id(); ?>

<?php switch ($match->last_action) {
	case 'SM':
	   echo '<u>' . __('You mailed') . '</u>';
	break;
	
	case 'RM':
	    echo '<u class="strong">' . __('%she_he% mailed', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) . '</u>';
	break;
	
	case 'SW':
	    echo '<u>' . __('You winked') . '</u>';
	break;
	
	case 'RW':
	    echo '<u class="strong">' . __('%she_he% winked', array('%she_he%' => ( $member->getSex() == 'M' ) ? 'He' : 'She')) . '</u>';
	break;
	
	default:
	break;
}
?>
