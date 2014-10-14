<?php if ($pager->hasResults()): ?>
    <div id="template_pager">
        <?php echo link_to_unless(
        is_null($pager->getPrevious()),
        '&lt;&lt;&nbsp;Previous',
        'feedbackTemplates/edit?id=' . $pager->getPrevious()
    ) ?>
        <?php echo link_to("Back to List", 'feedbackTemplates/list', array('class' => 'sec_link')) ?>
        <?php echo link_to_unless(
        is_null($pager->getNext()),
        'Next&nbsp;&gt;&gt;',
        'feedbackTemplates/edit?id=' . $pager->getNext()
    ) ?>
    </div>
<?php endif; ?>