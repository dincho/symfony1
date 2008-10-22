<table class="preview">
    <tr>
        <th>Flagged</th>
        <th>Username</th>
        <th>Category</th>
        <th>Comment</th>
    </tr>
    <?php foreach ($flags as $flag): ?>
        <tr>
            <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
            <td><?php echo $flag->getMember()->getUsername() ?></td>
            <td><?php echo $flag->getFlagCategory(); ?></td>
            <td><?php echo $flag->getComment() ?></td>
        </tr>
    <?php endforeach; ?>
</table>