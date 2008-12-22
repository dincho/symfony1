            <?php echo textarea_tag('note_content', null, array('rows' => 4, 'cols' => 57)); ?><br />
            <?php echo submit_tag('Add Note', array('class' => 'float-right button',  'name' => 'add_note')) ?><br /><br />
            <?php echo ($member->IsStarred()) ? image_tag('star_yellow.png') : image_tag('star_gray.png'); ?>
            <div id="member_notes" class="scrollable">
                <?php $i=0;foreach ($notes as $note): ?>
                <p <?php if($i%2 == 0) echo 'class="odd"' ?>>
                    <span><?php echo $note->getCreatedAt('m/d/Y') . '&nbsp;by&nbsp;' . $note->getUser() ?></span>
                    <?php echo $note->getText() ?>
                </p>
                <?php $i++;endforeach; ?>
            </div>