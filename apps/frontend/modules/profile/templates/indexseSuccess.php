<?php use_helper('Javascript', 'Date', 'prDate', 'dtForm', 'Text', 'Lightbox') ?>

<div>
    <?php echo __("%USERNAME%'s profile", array('%USERNAME%' => $member->getUsername()));?>
</div>
<br />
<div>
<?php $g = $member->getSex() == 'F' ? 'woman' : 'man';?> 
    <?php echo $member->getAge() ?> <?php echo __('year old '.$g );?>
</div>
<br />
<div>
    <?php echo $member->getEssayHeadline() ;?>
</div>
<br />
<div>
    <?php echo $member->getEssayIntroduction() ;?>
</div>

            <?php $area_info = ($member->getState()->getInfo()) ? addslashes(link_to(__('Area Information'), '@area_info?area_id=' . $member->getStateId() . '&username=' . $member->getUsername(), array('class' => 'sec_link'))) : null; ?>
                <div>
		<?php echo __('Country') ?> <?php echo format_country($member->getCountry()) ?>
		</div>
                <div>
		<?php echo __('Area') ?> <?php echo ($member->getStateId()) ? $member->getState() : __('None') ?>&nbsp;
		</div>
                <div>
		<?php echo __('City') ?> <?php echo $member->getCity() ?>
		</div>
                <?php if( !$member->getDontDisplayZodiac() ): ?>
                    <div>
			<?php echo __('Zodiac') ?> <?php echo $member->getZodiac()->getSign() ?>
		    </div>
                <?php endif; ?>
                <?php foreach ($questions as $question): ?>
                    <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <div>
			    
			    <?php echo $question->getDescTitle() ?>

                                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                    <?php echo $answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle() ?>
                                <?php else: ?>
                                    <?php echo $member_answers[$question->getId()]->getOther(); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
                    
                    <div>
			<?php echo __('Language'); ?> <?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (native)
			
			</div>
                    <?php elseif( $question->getType() == 'other_langs' ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
                            <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                <?php $lang_answers = $member_answers[$question->getId()]->getOtherLangs(); ?>
                                <?php foreach ($lang_answers as $lang_answer): ?>
                                    <?php if( $lang_answer['lang'] ): ?>
                                        <div>&nbsp;<?php echo format_language($lang_answer['lang']) ?> (<?php echo pr_format_language_level($lang_answer['level']) ?>)</div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div>&nbsp;<?php echo $member_answers[$question->getId()]->getOther(); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                


<?php 
$c = new Criteria;
$c->add(MemberPeer::ID, $member->getId(), Criteria::GREATER_THAN);
$m = MemberPeer::doSelectOne($c);
if ($m):?>
<div>
<?php echo link_to(__('[next]'), '@profilese?username='.$m->getUsername());?>
</div>
<?php endif;?>

<div>
<?php echo link_to(__('Click here to return to My Polish Love'), '@homepage');?>
</div>
