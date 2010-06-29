<?php if( isset($flags) && count($flags) ): ?>
    <div class="member_flags scrollable small_scrollable">
    <table>
        <tr>
            <th>Flagged</th>
            <th>Flagged by</th>
            <th>Category</th>
            <th>Comment</th>
        </tr>
        <?php foreach ($flags as $flag): ?>
            <tr>
                <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
                <td><?php echo link_to($flag->getMemberRelatedByFlaggerId()->getUsername(), 'members/edit?id=' . $flag->getFlaggerId()) ?></td>
                <td><?php echo $flag->getFlagCategory() ?></td>
                <td><?php echo $flag->getComment(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
<?php endif; ?>