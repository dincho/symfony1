<p><b>Online now: <?php echo $males_online ?> male <?php echo $females_online ?> Female members</b></p>
<table class="zebra">
<tr></tr>
    <tr>
        <td>New Members for review (members)</td>
        <td><?php echo Dashboard::getMembersPendingReview() ?></td>
    </tr>
    <tr>
        <td>New IMBRA applications for approval (IMBRA)</td>
        <td><?php echo Dashboard::getPendingImbras() ?></td>
    </tr>
    <tr>
        <td>New Flags pending review (flags)</td>
        <td><?php echo Dashboard::getFlagsPendingReview() ?></td>
    </tr>
    <tr>
        <td>New Flagging Suspension pending review (flags)</td>
        <td><?php echo Dashboard::getPendingFlaggingSuspension() ?></td>
    </tr>
    <tr>
        <td>New Messages from Members pending Reply (feedback)</td>
        <td><?php echo Dashboard::getMemberFeedbackForReply() ?></td>
    </tr>
    <tr>
        <td>New External Messages pending Reply (feedback)</td>
        <td><?php echo Dashboard::getExternalFeedbackForReply() ?></td>
    </tr>
    <tr>
        <?php //@FIXME ?>
        <td>New Deletions Pending Review</td>
        <td><?php //echo Dashboard::getNewDeletions() ?></td>
    </tr>
    <tr>
        <td>New Abandoned registrations pending review</td>
        <td><?php echo Dashboard::getNewAbandonations() ?></td>
    </tr>
    <tr>
        <td>New Bug/Suggestions Pending review (feedback)</td>
        <td><?php echo Dashboard::getBugsSuggestionsFeedback() ?></td>
    </tr>
    <tr>
        <td>New Messages between Members pending Review</td>
        <td><?php echo Dashboard::getMessagesPendingReview() ?></td>
    </tr>
</table>
