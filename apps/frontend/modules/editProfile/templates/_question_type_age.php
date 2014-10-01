<span class="date_tag_wrap">

    <?php $date_value = (isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getCustom()) ? $member_answers[$question->getId()]->getCustom() : array(); ?>
      <?php echo input_date_tag('answers['. $question->getid() .']', $date_value,  array('date_seperator' => '',
                                                                 'order' => array('d', 'm', 'y'),
                                                                 'year_start' => date('Y') - 18,
                                                                 'year_end' => date('Y') - 90,
                                                                 'use_month_numbers' => true,
                                                                 'include_custom' => array('day' => __('day'), 'month' => __('month'), 'year' => __('year') ),
                                                                  )) ?>
</span>
<span class="zodiac">
    <?php echo object_checkbox_tag($member, 'getDontDisplayZodiac', 'id=zodiac') ?>
    <label for="zodiac"><?php echo __('Don’t display my zodiac sign') ?></label>
</span>
