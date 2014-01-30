<p><b>Online now: <?php echo $males_online ?> male <?php echo $females_online ?> Female members</b></p>
<table class="zebra">
<tr>
    <th>
    </th>
    <th>
	less than 2 days
    </th>
    <th>
	3-7 days
    </th>
    <th>
	8 days and older
    </th>
</tr>
    <tr>
        <td>New Members for review (members)</td>
        <td><?php echo intval($members_pending_review->get2days()) ?></td>
        <td><?php echo intval($members_pending_review->get3days()) ?></td>
        <td><?php echo intval($members_pending_review->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Flags pending review (flags)</td>
        <td><?php echo intval($flags_pending_review->get2days()) ?></td>
        <td><?php echo intval($flags_pending_review->get3days()) ?></td>
        <td><?php echo intval($flags_pending_review->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Flagging Suspension pending review (flags)</td>
        <td><?php echo intval($pending_flagging_suspension->get2days()) ?></td>
        <td><?php echo intval($pending_flagging_suspension->get3days()) ?></td>
        <td><?php echo intval($pending_flagging_suspension->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Messages from Members pending Reply (feedback)</td>
        <td><?php echo intval($member_feedback_for_reply->get2days());?></td>
        <td><?php echo intval($member_feedback_for_reply->get3days());?></td>
        <td><?php echo intval($member_feedback_for_reply->get8days());?></td>
    </tr>
    <tr>
        <td>New External Messages pending Reply (feedback)</td>
        <td><?php echo intval($external_feedback_for_reply->get2days()) ?></td>
        <td><?php echo intval($external_feedback_for_reply->get3days()) ?></td>
        <td><?php echo intval($external_feedback_for_reply->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Deletions Pending Review</td>
        <td><?php echo intval($deletions_pending_review->get2days()) ?></td>
        <td><?php echo intval($deletions_pending_review->get3days()) ?></td>
        <td><?php echo intval($deletions_pending_review->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Abandoned registrations pending review</td>
        <td><?php echo intval($new_abandonations->get2days()) ?></td>
        <td><?php echo intval($new_abandonations->get3days()) ?></td>
        <td><?php echo intval($new_abandonations->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Bug/Suggestions Pending review (feedback)</td>
        <td><?php echo intval($bug_suggestions_feedback->get2days()) ?></td>
        <td><?php echo intval($bug_suggestions_feedback->get3days()) ?></td>
        <td><?php echo intval($bug_suggestions_feedback->get8days()) ?></td>
    </tr>
    <tr>
        <td>New Messages between Members pending Review</td>
        <td><?php echo intval($messages_pending_review->get2days()) ?></td>
        <td><?php echo intval($messages_pending_review->get3days()) ?></td>
        <td><?php echo intval($messages_pending_review->get8days()) ?></td>
    </tr>
</table>
