<span class="date_tag_wrap">
    <?php $date_value = (isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getCustom()) ? $member_answers[$question->getId()]->getCustom() : '01-01-' . (date('Y')-18); ?>
    <?php echo input_date_tag('answers['. $question->getid() .']', $date_value,  array('date_seperator' => '', 
                                                                 'order' => array('m', 'd', 'y'), 
                                                                 'year_start' => date('Y') - 90,
                                                                 'year_end' => date('Y') - 18,
                                                                 'use_month_numbers' => true,
                                                                  )) ?>
                                                                      
</span>
<span class="zodiac">
    <?php echo object_checkbox_tag($member, 'getDontDisplayZodiac', 'id=zodiac') ?>
    <label for="zodiac"><?php echo __('Don’t display my zodiac sign') ?></label>
</span>