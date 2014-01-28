<table class="preview">
    <tr>
        <th>Flagged</th>
        <th>Username</th>
        <th>Comment</th>
    </tr>
    <?php foreach ($flags as $flag): ?>
        <tr>
            <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
            <td><?php echo $flag->getMemberRelatedByMemberId()->getUsername() ?></td>
            <td><?php echo $flag->getComment() ?></td>
        </tr>
    <?php endforeach; ?>
</table>