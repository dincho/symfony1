            <label for="first_name">First Name</label>
            <?php echo object_input_tag($member, 'getFirstName', error_class('first_name')) ?><br />
            
            <label for="last_name">Last Name</label>
            <?php echo object_input_tag($member, 'getLastName', error_class('last_name')) ?><br />
        
            <label for="email">Email</label>
            <?php echo object_input_tag($member, 'getEmail', error_class('email')) ?><br />
             
            <label for="subscription_id">Subscription</label>
            <?php echo object_select_tag($member, 'getSubscriptionId') ?><br />
               
            <label for="member_status_id">Status</label>
            <?php echo object_select_tag($member, 'getMemberStatusId', array ('related_class' => 'MemberStatus','include_blank' => false,)) ?><br />
            
            <label for="orientation">Orientation</label>
            <?php echo select_tag('orientation', looking_for_options_admin($member->getSex(), $member->getLookingFor())) ?><br />
        
            <label for="member_id">ID</label>
            <var id="member_id"><?php echo $member->getId() ?></var><br />
            
            <label for="created_at">Member Since</label>
            <var id="created_at"><?php echo $member->getCreatedAt('M d, Y') ?></var><br />
            
            <label for="current_flags">Current Flags</label>
            <var id="current_flags"><?php echo $member->getCounter('CurrentFlags'); ?></var><br />
            
            <label for="total_flags">Total Flags</label>
            <var id="total_flags"><?php echo $member->getCounter('TotalFlags') ?></var><br />
            
            <label for="unsuspended">Un-suspended</label>
            <var id="unsuspended"><?php echo $member->getCounter('Unsuspensions') ?></var><br />
            
            <label for="reviewed">Reviewed</label>
            <var id="reviewed"><?php if($member->getReviewedById() ) echo $member->getReviewedBy() . '&nbsp;' . $member->getReviewedAt('m/d/Y')?></var><br />
            
            <label for="ip">IP</label>
            <var id="ip"><?php echo $member->getIP() ?></var><br />
            
            <label for="member_original_first_name">Original First Name</label>
            <var id="member_original_first_name"><?php echo $member->getOriginalFirstName() ?></var><br />
            
            <label for="member_original_last_name">Original Last Name</label>
            <var id="member_original_last_name"><?php echo $member->getOriginalLastName() ?></var><br />