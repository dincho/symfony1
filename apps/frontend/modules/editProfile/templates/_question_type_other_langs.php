<?php 
$lang_answers = ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOtherLangs() : array();
$req_answers = $sf_data->getRaw('sf_request')->getParameter('answers');
//if $lang_answers is not array the count return 1
$cnt = ( isset($req_answers[$question->getId()]) ) ? max(0, count( array_filter($req_answers[$question->getId()]) )-2) : max(0, count($lang_answers)-1);
?>

<div id="lang_container">
        <?php for($n=0; $n < 5; $n++): ?>
        <div id="lang_container_<?php echo $n; ?>" style="display: <?php echo ($n > $cnt ) ? 'none' : ''; ?>;">
                <?php echo pr_select_language_tag('answers['. $question->getid() .']['. $n.']',
                                      (isset($lang_answers[$n])) ? $lang_answers[$n]['lang'] : null, array('include_custom' => __('Select Language')) ) ?>
                <?php echo pr_select_language_level('answers['. $question->getid() .'][lang_levels]['. $n.']', (isset($lang_answers[$n])) ?  $lang_answers[$n]['level'] : 3, array('class' => 'language_level')) ?>

            <?php if( $n != 0 ): ?>
                <?php echo link_to_function(__('remove'), 'hide_lang_row('. $n .')', array('class' => 'sec_link')); ?>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
</div>
<?php $hidden_lang_ids = ( $cnt < 4 ) ? '['. implode(', ', range($cnt+1, 4)) .']' : 'Array()'; ?>

<?php echo javascript_tag('
var hidden_lang_ids = '.$hidden_lang_ids.';

function hide_lang_row(id)
{
    $("answers_'.$question->getId().'_" + id.toString()).value = "";
    $("answers_'.$question->getId().'_lang_levels_" + id.toString()).value = 3;
    
    $("lang_container_" + id.toString()).hide();
    hidden_lang_ids.push(id);
    validate_save_btn();
}

');?>