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
            
            
<br />            
<table border='0' >

<tr>
<td>  
		<?php echo __('Country') ?></td><td> <?php echo format_country($member->getCountry()) ?>
 </td>
</tr>		
<tr>
<td>
		<?php echo __('Area') ?> </td><td><?php echo ($member->getStateId()) ? $member->getState() : __('None') ?>&nbsp;
 </td>
</tr>       
<tr>
<td>
		<?php echo __('City') ?> </td><td><?php echo $member->getCity() ?>
 </td>
</tr> 
                <?php if( !$member->getDontDisplayZodiac() ): ?>
<tr>
<td>
			<?php echo __('Zodiac') ?> </td><td><?php echo $member->getZodiac()->getSign() ?>
 </td>
</tr> 
                <?php endif; ?>
                <?php foreach ($questions as $question): ?>
                    <?php if( ($question->getType() == 'radio' || $question->getType() == 'select') && $question->getDescTitle() ): ?>
                        <?php if( isset($member_answers[$question->getId()]) ): ?>
<tr>
<td>
			    
			    <?php echo $question->getDescTitle() ?>

                                <?php if( is_null($member_answers[$question->getId()]->getOther()) ): ?>
                                   </td><td> <?php echo $answers[$member_answers[$question->getId()]->getDescAnswerId()]->getTitle() ?>
                                <?php else: ?>
                                   </td><td> <?php echo $member_answers[$question->getId()]->getOther(); ?>
                                <?php endif; ?>
 </td>
</tr>
                        <?php endif; ?>
                    <?php elseif( $question->getType() == 'native_lang' && ( isset($member_answers[$question->getId()])) ): ?>
                    
<tr>

<td >
			<?php echo __('Language'); ?> </td><td><?php echo ( is_null($member_answers[$question->getId()]->getOther()) ) ? format_language($member_answers[$question->getId()]->getCustom()) : $member_answers[$question->getId()]->getOther() ?> (native)
			
 </td>
</tr>
<tr>
<td>
</td>
<td>
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
 </td>
</tr>
</table>               


<?php 
$c = new Criteria;
$c->add(MemberPeer::ID, $member->getId(), Criteria::GREATER_THAN);
$m = MemberPeer::doSelectOne($c);
if ($m):?>
<br />
<div>
<?php echo link_to(__('[next]'), '@profilese?username='.$m->getUsername());?>
</div>
<?php endif;?>
<br />
<div>
<?php echo link_to(__('Click here to return to My Polish Love'), '@homepage');?>
</div>
<br />