<?php
class Dashboard
{
    public static function getMembersPendingReview()
    {
        $c = new Criteria();
        $c->add(MemberPeer::REVIEWED_BY_ID, NULL, Criteria::ISNULL);
        
        return MemberPeer::doCount($c);
    }
    
    public static function getPendingImbras()
    {
        $c = new Criteria();
        $c->add(MemberImbraPeer::IMBRA_STATUS_ID, ImbraStatusPeer::PENDING);
        
        return MemberImbraPeer::doCount($c);
    }
    
    public static function getFlagsPendingReview()
    {
        return FlagPeer::doCount(new Criteria());
    }
    
    public static function getPendingFlaggingSuspension()
    {
        $c = new Criteria();
        $c->add(SuspendedByFlagPeer::CONFIRMED_BY, NULL, Criteria::ISNULL);
        
        return SuspendedByFlagPeer::doCount($c);
    }
    
    public static function getMemberFeedbackForReply()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
        $c->add(FeedbackPeer::MEMBER_ID, NULL, Criteria::ISNOTNULL);
        
        return FeedbackPeer::doCount($c);
    }
    
    public static function getExternalFeedbackForReply()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
        $c->add(FeedbackPeer::MEMBER_ID, NULL, Criteria::ISNULL);
        
        return FeedbackPeer::doCount($c);
    }
    
    /* @FIXME */
    public static function getNewDeletions()
    {
        $c = new Criteria();
        $c->add(MemberPeer::LAST_STATUS_CHANGE, MemberPeer::LAST_STATUS_CHANGE . '>' . MemberPeer::REVIEWED_AT, Criteria::CUSTOM);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::DELETED);
        
        return MemberPeer::doCount($c);        
    }
    
    public static function getNewAbandonations()
    {
        $c = new Criteria();
        $c->add(MemberPeer::LAST_STATUS_CHANGE, MemberPeer::LAST_STATUS_CHANGE . '>' . MemberPeer::REVIEWED_AT, Criteria::CUSTOM);
        $c->add(MemberPeer::MEMBER_STATUS_ID, MemberStatusPeer::ABANDONED);
        
        return MemberPeer::doCount($c);
    }
    
    public static function getBugsSuggestionsFeedback()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
        $c->add(FeedbackPeer::IS_READ, false);
        $c->add(FeedbackPeer::MAIL_TO, FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
        
        return FeedbackPeer::doCount($c);
    }
    
    //@deprecated
    /*    
    public static function getSuggestionFeedback()
    {
        $c = new Criteria();
        $c->add(FeedbackPeer::MAILBOX, FeedbackPeer::INBOX);
        $c->add(FeedbackPeer::IS_READ, false);
        $c->add(FeedbackPeer::MAIL_TO, FeedbackPeer::BUGS_SUGGESIONS_ADDRESS);
        
        return FeedbackPeer::doCount($c);
    }*/
    
    public static function getMessagesPendingReview()
    {
        $c = new Criteria();
        $c->add(MessagePeer::IS_REVIEWED, false);
        
        return MessagePeer::doCount($c);        
    }
}
