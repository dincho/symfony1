            <label for="username">Username</label>
            <var id="username"><?php echo link_to($member->getUsername(), 'members/edit?id=' . $member->getId() ) ?></var><br />

            <label for="first_name">First Name</label>
            <var id="first_name"><?php echo $member->getFirstName() ?></var><br />

            <label for="last_name">Last Name</label>
            <var id="last_name"><?php echo $member->getLastName(); ?></var><br />

            <label for="email">Email</label>
            <var id="email"><?php echo $member->getEmail(); ?></var><br />

            <label for="subscription">Subscription</label>
            <var id="subscription"><?php echo $member->getSubscription() ?></var><br />

            <label for="member_status_id">Status</label>
            <var id="member_status"><?php echo $member->getMemberStatus(); ?></var><br />

            <label for="member_id">Profile ID</label>
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
