<?php $action_name = sfContext::getInstance()->getActionName(); ?>
<div id="search_types">
<?php echo link_to_unless($action_name == 'mostRecent', __('Most Recent'), 'search/mostRecent', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'criteria', __('Custom (by Criteria)'), 'search/criteria', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'reverse', __('Reverse'), 'search/reverse', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'matches', __('Matches'), 'search/matches', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'byKeyword', __('by Keyword'), 'search/byKeyword', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo link_to_unless($action_name == 'profileID', __('Profile ID'), 'search/profileID', array('class' => 'sec_link', 'onclick' => "show_loader('match_results')")) ?>
</div>
