<?php $lang_answers = ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOtherLangs() : array() ?>
<?php for($n=1; $n<5; $n++): ?>
    <?php echo pr_select_language_tag('answers['. $question->getid() .']['. $n.']',
                          (isset($lang_answers[$n])) ? $lang_answers[$n]['lang'] : null, array('include_custom' => __('Select Language')) ) ?>
    <?php echo pr_select_language_level('answers['. $question->getid() .'][lang_levels]['. $n.']', (isset($lang_answers[$n])) ?  $lang_answers[$n]['level'] : null, array('class' => 'language_level', 'include_custom' => __('Select Level'))) ?>                 
    <br />
<?php endfor; ?>