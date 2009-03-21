<?php

/**
 * Subclass for performing query and update operations on the 'message_draft' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MessageDraftPeer extends BaseMessageDraftPeer
{
	/**
	 * Looks for existing draft or create new one
	 *
	 * @param int $id
	 * @param int $from_member_id
	 * @param int $to_member_id
	 * @return MessageDraft
	 */
	public static function retrieveOrCreate($id, $from_member_id, $to_member_id, $reply_to = null)
	{
        $c = new Criteria();
        $c->add(self::ID, $id);
        $c->add(self::FROM_MEMBER_ID, $from_member_id);
        $c->add(self::TO_MEMBER_ID, $to_member_id);
        if( !is_null($reply_to) ) $c->add(self::REPLY_TO, $reply_to);
        
        $draft = self::doSelectOne($c);
        
        if( !$draft )
        {
        	$draft = new MessageDraft();
        	$draft->setFromMemberId($from_member_id);
        	$draft->setToMemberId($to_member_id);
        	$draft->setReplyTo($reply_to);
        	$draft->save();
        }
        
        return $draft;
	}
	
	public static function clear($id, $from_member_id)
	{
		$c = new Criteria();
		$c->add(self::ID, $id);
        $c->add(self::FROM_MEMBER_ID, $from_member_id);
		MessageDraftPeer::doDelete($c);		
	}
}
