<?php
class Dashboard
{
    public static function getMembersPendingReview()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM member WHERE reviewed_by_id IS NULL ');
        return $ret[0];
    }
    
    public static function getFlagsPendingReview()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM flag');
        return $ret[0];
    }
    
    public static function getPendingFlaggingSuspension()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM suspended_by_flag WHERE  confirmed_by IS NULL');
        return $ret[0];
    }
    
    public static function getMemberFeedbackForReply()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM feedback WHERE  mailbox="'.FeedbackPeer::INBOX.'" AND member_id IS NOT NULL AND ' . FeedbackPeer::IS_READ . ' = 0');
        return $ret[0];
    }
    
    public static function getExternalFeedbackForReply()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM feedback WHERE  mailbox="'.FeedbackPeer::INBOX.'" AND member_id IS  NULL AND ' . FeedbackPeer::IS_READ . ' = 0');
        return $ret[0];
    }
    
    public static function getNewDeletions()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM member WHERE  last_status_change>reviewed_at AND member_status_id="'.MemberStatusPeer::CANCELED.'"');
        return $ret[0];
    }
    
    public static function getNewAbandonations()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM member WHERE  last_status_change>reviewed_at AND member_status_id="'.MemberStatusPeer::ABANDONED.'"');
        return $ret[0];
    }
    
    public static function getBugsSuggestionsFeedback()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM feedback WHERE  mailbox="'.FeedbackPeer::INBOX.'" AND mail_to="'.FeedbackPeer::BUGS_SUGGESIONS_ADDRESS.'"' . 'AND ' . FeedbackPeer::IS_READ . ' = 0');
        return $ret[0];
    }
    
    
    public static function getMessagesPendingReview()
    {
        $r = new CustomQueryObject();
        $ret =  $r->query('SELECT   SUM(IF(DATE(created_at) >= CURDATE() - interval 2 day, 1, 0)) as 2days, SUM(IF(DATE(created_at) < CURDATE() - interval 2 day AND DATE(created_at) >= CURDATE() - interval 7 day, 1, 0)) as 3days,  SUM(IF(DATE(created_at) < CURDATE() - interval 8 day , 1, 0)) as 8days FROM message WHERE is_reviewed = 0 AND type = 1');
        return $ret[0];
    }
}
