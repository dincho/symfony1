<?php use_helper('dtForm') ?>

<div><?php echo __("%USERNAME%'s profile", array('%USERNAME%' => $member->getUsername()));?></div><br />
<div><?php echo __('%AGE% year old %SEX%', array('%AGE%' => $member->getAge(), '%SEX%' => ($member->getSex() == 'F' ? 'woman' : 'man') ) );?></div><br />
<div><?php echo $member->getEssayHeadline() ;?></div><br />
<div><?php echo $member->getEssayIntroduction() ;?></div><br /> 

<table border="0">
    <tr>
        <td><?php echo __('Country') ?></td>
        <td><?php echo format_country($member->getCountry()) ?></td>
    </tr>		
    <tr>
        <td><?php echo __('Area') ?> </td>
        <td><?php echo ($member->getStateId()) ? $member->getState() : __('None') ?></td>
    </tr>       
    <tr>
        <td><?php echo __('City') ?> </td>
        <td><?php echo $member->getCity() ?></td>
    </tr> 
    <?php if( !$member->getDontDisplayZodiac() ): ?>
    <tr>
        <td><?php echo __('Zodiac') ?></td>
        <td><?php echo $member->getZodiac()->getSign() ?></td>
    </tr> 
    <?php endif; ?>
    <?php foreach ($questions as $question): ?>
        <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
            <?php if( isset($member_answers[$question->getId()]) ): ?>
            <tr>
                <td><?php echo __($question->getDescTitle(ESC_RAW)) ?></td>
                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                   <td><?php echo __(strip_tags(html_entity_decode($answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle(ESC_RAW)))) ?></td>
                <?php else: ?>
                   <td><?php echo $member_answers[$question->getId()]->getOther(); ?></td>
                <?php endif; ?>
            </tr>
            <?php endif; ?>
        <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
            <tr>
                <td><?php echo __('Language'); ?></td>
                <td><?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (native)</td>
            </tr>
        <?php elseif( $question->getType() == 'other_langs' ): ?>
            <?php if( isset($member_answers[$question->getId()]) ): ?>
                <tr>
                <td></td>
                <td> 
                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                    <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                    <?php foreach ($lang_answers as $lang_answer): ?>
                        <?php if( $lang_answer['lang'] ): ?>
                            <?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo $member_answers[$question->getId()]->getOther(); ?>
                <?php endif; ?>
             </td>
            </tr> 
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</table>               

<br />
<?php if($next_member): ?>
    <?php echo link_to(__('[next]'), '@profilese?username='.$next_member->getUsername());?><br /><br />
<?php endif;?>

<?php echo link_to(__('Click here to return to My Polish Love'), '@homepage');?>