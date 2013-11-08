            <?php echo textarea_tag('note_content', null, array('rows' => 4, 'cols' => 57)); ?><br />
            <?php echo submit_tag('Add Note', array('class' => 'float-right button',  'name' => 'add_note', 'onclick' => 'if($(note_content).value == ""){return false;}')) ?><br /><br />
            <?php echo link_to(($member->IsStarred()) ? image_tag('star_yellow.png') : image_tag('star_gray.png'), 'members/star?id=' . $member->getId()); ?>
            <div id="member_notes" class="scrollable">
                <?php $i=0;foreach ($notes as $note): ?>
                <p <?php if($i%2 == 0) echo 'class="odd"' ?>>
                    <span><?php echo $note->getCreatedAt('m/d/Y') . '&nbsp;by&nbsp;' .
                            ($note->getUser() ? $note->getUser() : 'SYSTEM') ?> 
                      <?php echo link_to('delete', 'members/deleteNote?noteId='.$note->getId().'&id='.$member->getId(), 
                          array('confirm' => 'Delete the Note.\nAre you sure?', 'class'=>'delete',)
                      ) ?>
                      
                    </span>
                    <?php $note_id = "edit_note_".$note->getId() ?>
                    <div id="<?php echo $note_id; ?>" > <?php echo $note->getText(); ?></div>
                      <?php echo input_in_place_editor_tag($note_id, 'members/updateNote?noteId='.$note->getId().'&id='.$member->getId(), 
                        array('cols' => 55, 'rows' => 4, 'save_text' =>'save')) ?>
                </p>
                <hr />
                <?php $i++;endforeach; ?>
            </div>
