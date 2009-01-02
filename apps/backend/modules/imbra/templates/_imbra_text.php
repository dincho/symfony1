<?php if ($imbra): ?>
    <?php $imbra_questions = ImbraQuestionPeer::doSelectWithI18n(new Criteria(), $culture); ?>
    <?php $imbra_answers = $imbra->getImbraAnswersArray(); ?>

    <?php if( $imbra->getText($culture) ): ?>
        <?php echo $imbra->getText($culture) ?>
    <?php else: ?>
        <p class="public_reg_notice"><?php echo strtr('US law requires that US customers, even if living abroad, provide certain background information when using a foreign dating website. This is what {Name} has told us about himself. This information has not been verified and we do not take any responsibility for its accuracy. If you ever decide to marry {Name}, and he will sponsor you to come to USA, US Embassy will require {Name} to go through criminal background check.', array('{Name}' => $member->getFullName()) ); ?></p>
        <?php foreach($imbra_questions as $imbra_question): ?>
            <p><?php echo $imbra_question->getParsedAnswer($member, $imbra_answers) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>