<?php use_helper('Object', 'dtForm') ?>

<?php echo __('Here you may change your self-description.') ?><br />
<span><?php echo __('Make changes and click Save at the bottom of the page.') ?></span><br />

<?php echo form_tag('editProfile/selfDescription', array('id' => 'self_desc_form')) ?>
    <?php $i=1; ?>
    <label class="title">1. What's your birthday? <span><?php echo __('(If you\'re not 19 or older, you are not allowed to be here - you must leave now!)') ?></span></label>
    <span class="date_tag_wrap">
        <?php $date_value = ($member->getBirthday()) ? $member->getBirthday() : '01-01-' . (date('Y')-18); ?>
        <?php echo input_date_tag('birth_day', $date_value,  array('date_seperator' => '', 
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
    
    <?php foreach ($questions as $question): ?>
      <label class="title"><?php echo ++$i; ?>. <?php echo $question->getTitle() ?> <span><?php echo ($question->getIsRequired()) ? __('(select one)') : __('(optional, select one)')?></span></label>
      <?php if( $question->getType() == 'radio' && isset($answers[$question->getId()]) ): ?>
        <?php foreach ($answers[$question->getId()] as $answer): ?>
          <?php echo radiobutton_tag('answers['. $question->getid() .']', 
                                     $answer->getId(),
                                     ( isset($member_answers[$question->getId()]) && $member_answers[$question->getId()]->getDescAnswerId() == $answer->getId()) ? true : false,
                                     array('class' => 'radio') ) ?>
          <label for="<?php echo 'answers_'. $question->getId(). '_' .$answer->getId() ?>"><?php echo html_entity_decode($answer->getTitle(), null, 'utf-8') ?></label><br />
        <?php endforeach; ?>
      <?php elseif( $question->getType() == 'select' && isset($answers[$question->getId()]) ): ?>
        <?php echo select_tag('answers['. $question->getid() .']',
                              objects_for_select($answers[$question->getId()],
                              'getId', 
                              'getTitle',
                              ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getDescAnswerId() : null )) ?><br />
      <?php elseif( $question->getType() == 'native_lang' ): ?>
        <?php echo pr_select_language_tag('answers['. $question->getid() .']',
                              $member->getLanguage() ) ?><br />
      <?php elseif( $question->getType() == 'other_langs' ): ?>
        <?php $lang_answers = ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getOtherLangs() : array() ?>
        <?php for($n=1; $n<5; $n++): ?>
            <?php echo pr_select_language_tag('answers['. $question->getid() .']['. $n.']',
                                  (isset($lang_answers[$n])) ? $lang_answers[$n]['lang'] : null, array('include_custom' => 'Select Language') ) ?>
            <?php echo pr_select_language_level('answers['. $question->getid() .'][lang_levels]['. $n.']', (isset($lang_answers[$n])) ?  $lang_answers[$n]['level'] : null, array('class' => 'language_level', 'include_custom' => 'Select Level')) ?>                 
            <br />
        <?php endfor; ?>
      <?php endif; ?>
      
    <?php endforeach; ?>
        
    <br /><br /><?php echo link_to(__('Cancel and go to dashboard'), 'dashboard/index', array('class' => 'sec_link')) ?><br />
    <?php echo submit_tag('Save', array('class' => 'save')) ?>
</form>
<span><?php echo __('Note: You will be able to change this information later.') ?></span>