<table>
<?php foreach ($history->getParameters() as $key => $value): ?>
    <tr>
        <td><?php echo $key ?></td>
        <td><?php echo $value ?></td>
    </tr>
<?php endforeach; ?>
</table>