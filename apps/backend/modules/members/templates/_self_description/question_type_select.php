<?php echo select_tag('answers['. $question->getid() .']',
                      objects_for_select($answers[$question->getId()],
                      'getId', 
                      'getTitle',
                      ( isset($member_answers[$question->getId()]) ) ? $member_answers[$question->getId()]->getDescAnswerId() : array(), 
                      array('include_custom' => $question->getIncludeCustom()) )) ?><br />