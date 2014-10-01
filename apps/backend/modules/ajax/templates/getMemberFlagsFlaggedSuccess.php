<table class="preview">
    <tr>
        <th>Flagged</th>
        <th>Flagged By</th>
        <th>Comment</th>
    </tr>
    <?php foreach ($flags as $flag): ?>
        <tr>
            <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
            <td><?php echo $flag->getMemberRelatedByFlaggerId()->getUsername() ?></td>
            <td><?php echo $flag->getComment() ?></td>
        </tr>
    <?php endforeach; ?>
</table>
