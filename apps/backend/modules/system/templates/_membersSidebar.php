<?php use_helper('I18N'); ?>

<?php echo form_tag('members/list', array('method' => 'get'));?>
<?php echo input_hidden_tag('filter', 'filter'); ?>

<ul id="left_menu">
    <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
    <li>Catalog:</li>
    <li>
        <?php echo select_tag('filters[cat_id]', options_for_select($catalogues, $filters['cat_id'])); ?>
    </li> 
    <li>Stared:</li>
    <?php foreach($starred_array as $key => $value): ?>
    <li>
        <?php echo checkbox_tag('filters[starred][]', $key, @in_array($key, $filters['starred']) );?>
        <label><?php echo $value; ?></label>
    </li>
    <?php endforeach; ?>
    <li>Sex:</li>
    <?php foreach($sex_array as $key => $value): ?>
    <li>
        <?php echo checkbox_tag('filters[sex][]', $key, @in_array($key, $filters['sex']) );?>
        <label><?php echo $value; ?></label>
    </li>
    <?php endforeach; ?>
    
    <li>&nbsp;</li>
    
    <li>Subscription Type:</li>
    <?php foreach($subscriptions as $subscription): ?>
    <li>
        <?php echo checkbox_tag('filters[subscription_id][]', $subscription->getId(), @in_array($subscription->getId(), $filters['subscription_id']) );?>
        <label><?php echo $subscription->getTitle(); ?></label>
    </li>
    <?php endforeach; ?>
    
    <li>&nbsp;</li>
    
    <li>Country:</li>
    <?php foreach($countries as $country): ?>
    <li>
        <?php echo checkbox_tag('filters[countries][]', $country, @in_array($country, $filters['countries']) );?>
        <label><?php echo format_country($country) ?></label>
    </li>
    <?php endforeach; ?>
    <li>
        <?php echo checkbox_tag('filters[countries][]', 'THE_REST', @in_array('THE_REST', $filters['countries']) );?>
        <label>The Rest</label>
    </li>
    
    <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
    <li>&nbsp;</li>
    
    <li>Status:</li>
    <?php foreach($statuses as $status): ?>
    <li>
        <?php echo checkbox_tag('filters[status_id][]', $status->getId(), @in_array($status->getId(), $filters['status_id']) );?>
        <label><?php echo $status->getTitle(); ?></label>
    </li>
    <?php endforeach; ?>
    <li>
        <?php echo checkbox_tag('filters[no_email_confirmation]', 1, isset($filters['no_email_confirmation']) );?>
        <label>Not Activated Yet</label>
    </li>
    
    <li>&nbsp;</li>
        
    <li>Language:</li>
    <?php foreach($languages as $language): ?>
    <li>
        <?php echo checkbox_tag('filters[languages][]', $language, @in_array($language, $filters['languages']) );?>
        <label><?php echo format_language($language) ?></label>
    </li>
    <?php endforeach; ?>
    
    <li class="sidebar_actions"><?php echo submit_tag('Apply'); ?></li>
    <li>&nbsp;</li>
</ul>
</form>

