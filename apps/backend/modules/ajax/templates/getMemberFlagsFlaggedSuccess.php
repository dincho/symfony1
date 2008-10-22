<table class="preview">
    <tr>
        <th>Flagged</th>
        <th>Flagged By</th>
        <th>Category</th>
        <th>Comment</th>
    </tr>
    <?php foreach ($flags as $flag): ?>
        <tr>
            <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
            <td><?php echo $flag->getFlagger()->getUsername() ?></td>
            <td><?php echo $flag->getFlagCategory(); ?></td>
            <td><?php echo $flag->getComment() ?></td>
        </tr>
    <?php endforeach; ?>
</table>