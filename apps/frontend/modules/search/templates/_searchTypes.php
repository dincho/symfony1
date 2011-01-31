<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<div id="search_types">
<?php $options = array('query_string' =>'filters[location]=0', 'class' => 'sec_link'); ?>
<?php $search_options = array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results','".__('Updating Results...')."')"); ?>
<?php echo link_to_unless($action_name == 'mostRecent', __('Most Recent'), 'search/mostRecent', $options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'lastLogin', __('Last Login'), 'search/lastLogin', $action_name == 'lastLogin' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'criteria', __('Custom (by Criteria)'), 'search/criteria', $action_name == 'criteria' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'reverse', __('Reverse'), 'search/reverse', $action_name == 'reverse' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'matches', __('Matches'), 'search/matches', $action_name == 'matches' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byKeyword', __('by Keyword'), 'search/byKeyword', $action_name == 'byKeyword' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'profileID', __('Profile ID'), 'search/profileID', $action_name == 'profileID' ? $options : $search_options ) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byRate', __('by Rate'), 'search/byRate', $action_name == 'byRate' ? $options : $search_options ) ?>
</div>
