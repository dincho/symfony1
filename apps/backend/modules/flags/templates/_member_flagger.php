<?php if( isset($flags) && count($flags) ): ?>
    <div class="member_flags scrollable small_scrollable">
    <table>
        <tr>
            <th>Flagged</th>
            <th>Username</th>
            <th>Comment</th>
        </tr>
        <?php foreach ($flags as $flag): ?>
            <tr>
                <td><?php echo $flag->getCreatedAt('m/d/Y') ?></td>
                <td><?php echo link_to($flag->getMemberRelatedByMemberId()->getUsername(), 'members/edit?id=' . $flag->getMemberId() ) ?></td>
                <td><?php echo $flag->getComment(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
<?php endif; ?>
