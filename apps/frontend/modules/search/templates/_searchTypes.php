<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<div id="search_types">
<?php echo link_to_unless($action_name == 'mostRecent', __('Most Recent'), 'search/mostRecent', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'lastLogin', __('Last Login'), 'search/lastLogin', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'criteria', __('Custom (by Criteria)'), 'search/criteria', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'reverse', __('Reverse'), 'search/reverse', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'matches', __('Matches'), 'search/matches', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byKeyword', __('by Keyword'), 'search/byKeyword', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'profileID', __('Profile ID'), 'search/profileID', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byRate', __('by Rate'), 'search/byRate', array('query_string' =>'filters[location]=0', 'class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
</div>
