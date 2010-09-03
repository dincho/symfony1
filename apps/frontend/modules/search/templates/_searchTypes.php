<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<div id="search_types">
<?php $options = array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results','".__('Updating Results...')."')"); ?>
<?php echo link_to_unless($action_name == 'mostRecent', __('Most Recent'), 'search/mostRecent', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'lastLogin', __('Last Login'), 'search/lastLogin', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'criteria', __('Custom (by Criteria)'), 'search/criteria', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'reverse', __('Reverse'), 'search/reverse', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'matches', __('Matches'), 'search/matches', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byKeyword', __('by Keyword'), 'search/byKeyword', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'profileID', __('Profile ID'), 'search/profileID', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byRate', __('by Rate'), 'search/byRate', $options ) ?>
</div>
