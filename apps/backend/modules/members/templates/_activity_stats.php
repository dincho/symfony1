<table class="details">
    <tbody>
        <tr>
            <th>Sent Messages (This Month)</th>
            <td><?php echo $member->getCounter('SentMessages') ?></td>
        </tr>
        <tr>
            <th>Sent Messages (All)</th>
            <td><?php echo $member->getNbSentMessages() ?></td>
        </tr>

        <tr>
            <th>Received Messages</th>
            <td><?php echo $member->getCounter('ReceivedMessages') ?></td>
        </tr>

        <tr>
            <th>Sent Winks</th>
            <td colspan="2"><?php echo $member->getCounter('SentWinks') ?></td>
        </tr>

        <tr>
            <th>Received Winks</th>
            <td colspan="2"><?php echo $member->getCounter('ReceivedWinks') ?></td>
        </tr>

        <tr>
            <th>On Others Hotlist</th>
            <td colspan="2"><?php echo $member->getCounter('OnOthersHotlist') ?></td>
        </tr>

        <tr>
            <th>Members on Hotlist</th>
            <td colspan="2"><?php echo $member->getCounter('Hotlist') ?></td>
        </tr>

        <tr>
            <th>Priv. Photo Access Given</th>
            <td colspan="2"><?php echo $member->getPrivatePhotoAccessGiven() ?></td>
        </tr>

        <tr>
            <th>Priv. Photo Access Received</th>
            <td colspan="2"><?php echo $member->getPrivatePhotoAccessReceived() ?></td>
        </tr>

        <tr>
            <th>Priv. Photo Request Received</th>
            <td colspan="2"><?php echo $member->getPrivatePhotoRequestReceived() ?></td>
        </tr>

        <tr>
            <th>Priv. Photo Request Sent</th>
            <td colspan="2"><?php echo $member->getPrivatePhotoRequestSent() ?></td>
        </tr>
    </tbody>
</table>
