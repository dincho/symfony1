<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Jan 28, 2009 10:52:33 AM
 * 
 */
 
class Reports
{
    public static function getRegistration($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT IF(ISNULL(t2.member_status_id), "Abandoned", "Abandoned  Finalized") AS title,
                %PERIODS_SQL%
                FROM member_status_history AS t1
                LEFT JOIN member_status_history AS t2 ON (t1.member_id = t2.member_id AND t2.member_status_id = %STATUS_ACTIVE% AND t2.created_at > (t1.created_at + INTERVAL 24 HOUR) )
                WHERE t1.member_status_id = %STATUS_ABANDONED%
                GROUP BY title';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 'IF(ISNULL(t2.member_status_id), t1.created_at, t2.created_at)', 
              '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to'], '%STATUS_ACTIVE%' => MemberStatusPeer::ACTIVE, '%STATUS_ABANDONED%' => MemberStatusPeer::ABANDONED));
        
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public static function getFlagsSuspensions($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT %TITLE_FIELD%, %PERIODS_SQL%
                FROM flag AS t1
                LEFT JOIN flag_category AS t2 ON t1.flag_category_id = t2.id
                GROUP BY t1.flag_category_id WITH ROLLUP';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%TITLE_FIELD%' => 't2.title', '%DATE_FIELD%' => 't1.created_at', 
                                '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to'])); 
        
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public static function getSuspensions($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT %TITLE_FIELD%, %PERIODS_SQL%
                FROM member_status_history AS t1
                WHERE t1.member_status_id IN (%STATUSES%)
                GROUP BY title';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%TITLE_FIELD%' => '"# of suspended members" AS title', '%DATE_FIELD%' => 't1.created_at', 
                                '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to'], 
                                '%STATUSES%' => implode(',', array(MemberStatusPeer::SUSPENDED, MemberStatusPeer::SUSPENDED_FLAGS, MemberStatusPeer::SUSPENDED_FLAGS_CONFIRMED)))); 
        
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public static function getMostActiveFlaggers()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT %TITLE_FIELD%,
                SUM(IF( t1.flag_category_id = 1, 1, 0 )) AS inappropriate,
                SUM(IF( t1.flag_category_id = 2, 1, 0 )) AS spam,
                SUM(IF( t1.flag_category_id = 3, 1, 0 )) AS scam,
                SUM(IF( t1.flag_category_id = 4, 1, 0 )) AS other,
                COUNT(t1.id) AS total
                FROM flag AS t1
                LEFT JOIN member AS t2 ON (t1.flagger_id = t2.id)
                GROUP BY t1.flagger_id 
                ORDER BY total DESC LIMIT 0,5';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%TITLE_FIELD%' => 't2.username', '%DATE_FIELD%' => 't1.created_at')); 
                                
        
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public static function getActiveMembersBySubscription($subscription_id)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT
                CASE
                    WHEN (t2.sex = "M") THEN "(men)"
                    WHEN (t2.sex = "F") THEN "(women)"
                END AS title, %PERIODS_SQL%
            FROM subscription_history AS t1
            LEFT JOIN member AS t2 ON t1.member_id = t2.id
            WHERE t1.subscription_id = %SUBSCRIPTION_ID%
            AND t1.member_status_id = 1
            GROUP BY title WITH ROLLUP';
        
        $sql = self::addPeriods2($sql);
        $sql = strtr($sql, array('%SUBSCRIPTION_ID%' => $subscription_id, '%DATE_FIELD%' => 't1.created_at')); 
                                
        
        $objects = $customObject->query($sql);
        return $objects;        
    }
    
    public static function getActiveMembersByLocation()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT
                CASE
                    WHEN (t2.country = "PL") THEN "Polish" 
                    WHEN (t2.country = "US") THEN "Foreign (US)" 
                    WHEN (t2.country != "US" AND t2.country != "PL") THEN "Foreign (Non-US)" 
                END AS title, %PERIODS_SQL%
            FROM subscription_history AS t1
            LEFT JOIN member AS t2 ON t1.member_id = t2.id
            WHERE t1.member_status_id = 1
            GROUP BY title DESC';
        
        $sql = self::addPeriods2($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 't1.created_at')); 
                                
        
        $objects = $customObject->query($sql);
        return $objects;        
    }
    
    public static function getActiveMembersTotal()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT
                CASE
                    WHEN (t2.sex = "M") THEN "Total men"
                    WHEN (t2.sex = "F") THEN "Total women"
                END AS title, %PERIODS_SQL%
            FROM subscription_history AS t1
            LEFT JOIN member AS t2 ON t1.member_id = t2.id
            WHERE t1.member_status_id = 1
            GROUP BY title ASC WITH ROLLUP';
        
        $sql = self::addPeriods2($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 't1.created_at')); 
                                
        
        $objects = $customObject->query($sql);
        return $objects;        
    }

    public static function getMemberContact($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT title, created_at,
                %PERIODS_SQL%
                FROM
                    (SELECT t1.created_at, "Messages Sent" AS title
                    FROM message AS t1
                    WHERE t1.type = 1
                    
                    UNION ALL
                    
                    SELECT t2.created_at, "Winks Sent" AS title
                    FROM wink AS t2
                    WHERE t2.sent_box = 1
                    
                    UNION ALL
                    
                    SELECT hl.created_at, "Hotlists Added" AS title
                    FROM hotlist AS hl
                    WHERE hl.is_new = 1

                    UNION ALL
                    
                    SELECT mr.created_at, "Rates Given" AS title
                    FROM member_rate AS mr
                    WHERE mr.rate > 3

                    UNION ALL
                    
                    SELECT ppp.created_at, "Pr. Photos Access Granted" AS title
                    FROM private_photo_permission AS ppp

                    ) AS t3 
                GROUP BY title DESC WITH ROLLUP';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 'created_at', '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to']));
        
        $objects = $customObject->query($sql);
        return $objects;
    }
    
    public static function getLoginActivity()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT
                    IF( DATE(t1.created_at) = CURDATE(), AVG(TO_DAYS(t1.created_at) - TO_DAYS(t1.last_login)), 0 ) AS today,
                    IF( DATE(t1.created_at) = (CURDATE() - INTERVAL 1 YEAR), AVG(TO_DAYS(t1.created_at) - TO_DAYS(t1.last_login)), 0 ) AS today_ly,
                    IF( DATE(t1.created_at) = (CURDATE() - INTERVAL 30 DAY), AVG(TO_DAYS(t1.created_at) - TO_DAYS(t1.last_login)), 0 ) AS 30da,
                    IF( DATE(t1.created_at) = (CURDATE() - INTERVAL 90 DAY), AVG(TO_DAYS(t1.created_at) - TO_DAYS(t1.last_login)), 0 ) AS 90da
                FROM
                member_login_history AS t1';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 't1.created_at'));
        
        $objects = $customObject->query($sql);
        return $objects[0];
    }
    
    public static function getDaylySalesByStatus($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT title, sort_order, dt,
                %PERIODS_SQL%
                FROM
                (SELECT "01) Members" AS title, 1 AS sort_order, t2.created_at AS dt FROM member AS t2 WHERE t2.member_status_id NOT IN (4,8,9)
                    UNION
                    SELECT
                        CASE
                            WHEN t1.member_status_id = 5 THEN "02) Deactivations (user)"
                            WHEN t1.member_status_id = 7 THEN "03) Deletions (user)"
                            WHEN t1.member_status_id = 1 AND t1.from_status_id = 5 THEN "04) Reactivations (user)"
                            WHEN t1.member_status_id = 2 THEN "05) Suspensions (admin)"
                            WHEN t1.member_status_id IN(6,10) THEN "06) Suspensions (flags)"
                            WHEN t1.member_status_id = 1 AND t1.from_status_id IN(2,6,10) THEN "07) Unsuspensions (admin)"
                            WHEN t1.member_status_id = 3 THEN "08) Removals (deletions by admin)"
                            WHEN t1.member_status_id = 11 THEN "09) Deactivations (auto)"
                        END AS title, 2 AS sort_order, t1.created_at AS dt
                
                    FROM member_status_history AS t1
                    WHERE t1.member_status_id NOT IN (1,4,8,9) 
                    OR (t1.member_status_id = 1 AND t1.from_status_id IN (5,2,6,10))
                ) AS t4
                GROUP BY sort_order ASC, title';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 't4.dt', '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to']));
        
        $objects = $customObject->query($sql);
        return $objects;        
    }
    
    public static function getDaylySalesPaidMembers($filters)
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT title, dt,
                %PERIODS_SQL%
                FROM
                (SELECT
                        CASE
                            WHEN t1.txn_type = "subscr_payment" AND t1.payment_status = "Completed" THEN "09) Memb. Upgrade (paid)"
                            WHEN t1.txn_type = "subscr_cancel" THEN "13) Memb. Un-Subscriptions"
                        END AS title, t1.created_at AS dt
                
                    FROM ipn_history AS t1
                    WHERE ((t1.txn_type = "subscr_payment" AND t1.subscr_id IS NOT NULL) OR t1.txn_type = "subscr_cancel")
                    AND t1.paypal_response = "VERIFIED"
                    UNION
                    SELECT
                        CASE
                            WHEN t2.member_status_id = 7 THEN "14) Deletions (user)"
                            WHEN t2.member_status_id = 2 THEN "15) Suspensions (admin)"
                            WHEN t2.member_status_id IN(6,10) THEN "16) Suspensions (flags)"
                            WHEN t2.member_status_id = 1 AND t2.from_status_id IN(2,6,10) THEN "17) Unsuspensions (admin)"
                            WHEN t2.member_status_id = 3 THEN "18) Removals (deletions by admin)"
                        END AS title, t2.created_at AS dt
                
                    FROM member_status_history AS t2
                    WHERE t2.member_status_id NOT IN (1,4,5,8,9) 
                    OR (t2.member_status_id = 1 AND t2.from_status_id IN (2,6,10))
                ) AS t4
                GROUP BY t4.title ASC';
        
        $sql = self::addPeriods($sql);
        $sql = strtr($sql, array('%DATE_FIELD%' => 't4.dt', '%DF%' => $filters['date_from'], '%DT%' => $filters['date_to']));
        
        $objects = $customObject->query($sql);
        return $objects;        
    }
    
    public static function getOutgoingEmails()
    {
        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT `mail_config` as email, 
                  SUM(IF( DATE(`at`) = CURDATE(), cnt, 0 )) AS today, 
                  SUM(IF( DATE(`at`) = (CURDATE() - INTERVAL 1 DAY), cnt, 0 )) AS yesterday, 
                  SUM(IF( DATE(`at`) = (CURDATE() - INTERVAL 2 DAY), cnt, 0 )) AS two_days_ago, 
                  sum(cnt) as all_time, 
                  DATEDIFF(max(`at`),min(`at`))+1 as all_days, 
                  sum(cnt)/(DATEDIFF(max(`at`),min(`at`))+1) as average_day 
                  FROM
                    ( SELECT `mail_config` , DATE(`created_at`) as at,
                        count(*) as cnt
                        FROM `pr_mail_message` WHERE status = "sent"  
                        group by `mail_config`,`at` 
                      union 
                      SELECT `mail_config` , `at`, `cnt` FROM `pr_mail_sum`) t
                  group by `email` order by `email`';
             
        $objects = $customObject->query($sql);
        return $objects;        
    }

    protected static function addPeriods($sql)
    {
        $periods_sql = 'SUM(IF( DATE(%DATE_FIELD%) = CURDATE(), 1, 0 )) AS today,
                        SUM(IF( DATE(%DATE_FIELD%) = (CURDATE() - INTERVAL 1 YEAR), 1, 0 )) AS today_ly,
                        SUM(IF( YEAR(%DATE_FIELD%) = YEAR(CURDATE()) AND MONTH(%DATE_FIELD%) = MONTH(CURDATE()), 1, 0 )) AS mtd,
                        SUM(IF( YEAR(%DATE_FIELD%) = YEAR(CURDATE() - INTERVAL 1 YEAR) AND MONTH(%DATE_FIELD%) = MONTH(CURDATE()) AND DAY(%DATE_FIELD%) <= DAY(CURDATE()), 1, 0 )) AS mtd_ly,
                        SUM(IF( YEAR(%DATE_FIELD%) = YEAR(CURDATE()), 1, 0 )) AS ytd,
                        SUM(IF( YEAR(%DATE_FIELD%) = YEAR(CURDATE() - INTERVAL 1 YEAR) AND MONTH(%DATE_FIELD%) <= MONTH(CURDATE()) AND DAY(%DATE_FIELD%) <= DAY(CURDATE()), 1, 0 )) AS ytd_ly,
                        COUNT(*) AS to_date,
                        SUM(IF( UNIX_TIMESTAMP(%DATE_FIELD%) BETWEEN %DF% AND %DT%, 1, 0 )) AS period';
        return strtr($sql, array('%PERIODS_SQL%' => $periods_sql));
    }

    /* old one
    protected static function addPeriods2($sql)
    {
        $periods_sql = 'SUM(1) AS today,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE(), 1, 0 )) AS 7da,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE(), 1, 0 )) AS 30da,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 3 MONTH AND CURDATE(), 1, 0 )) AS 3ma,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE(), 1, 0 )) AS 6ma,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 1 YEAR AND CURDATE(), 1, 0 )) AS 1ya,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 2 YEAR AND CURDATE(), 1, 0 )) AS 2ya,
                        SUM(IF( DATE(%DATE_FIELD%)  BETWEEN CURDATE() - INTERVAL 3 YEAR AND CURDATE(), 1, 0 )) AS 3ya';
        return strtr($sql, array('%PERIODS_SQL%' => $periods_sql));
    }
    */

/*    
    protected static function addPeriods2($sql)
    {
        $periods_sql = 'SUM(IF(CURDATE() BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS today,
                        SUM(IF((CURDATE() - INTERVAL 7 DAY) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 7da,
                        SUM(IF((CURDATE() - INTERVAL 30 DAY) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 30da,
                        SUM(IF((CURDATE() - INTERVAL 3 MONTH) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 3ma,
                        SUM(IF((CURDATE() - INTERVAL 6 MONTH) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 6ma,
                        SUM(IF((CURDATE() - INTERVAL 1 YEAR) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 1ya,
                        SUM(IF((CURDATE() - INTERVAL 2 YEAR) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 2ya,
                        SUM(IF((CURDATE() - INTERVAL 3 YEAR) BETWEEN DATE(COALESCE(t1.from_date, "2009-01-28")) AND DATE(t1.created_at) , 1, 0 )) AS 3ya';
        return strtr($sql, array('%PERIODS_SQL%' => $periods_sql));
    }
*/
    protected static function addPeriods2($sql)
    {
        $periods_sql = 'SUM(IF(t1.id = last_subscription_id_on(t1.member_id, CURDATE()), 1, 0 )) AS today,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 7 DAY)), 1, 0 )) AS 7da,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 30 DAY)), 1, 0 )) AS 30da,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 3 MONTH)), 1, 0 )) AS 3ma,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 6 MONTH)), 1, 0 )) AS 6ma,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 1 YEAR)), 1, 0 )) AS 1ya,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 2 YEAR)), 1, 0 )) AS 2ya,
                        SUM(IF(t1.id = last_subscription_id_on(t1.member_id, (CURDATE() - INTERVAL 3 YEAR)), 1, 0 )) AS 3ya';
        return strtr($sql, array('%PERIODS_SQL%' => $periods_sql));
    }
}
/*
SELECT `mail_config` , DATE(`created_at`) as at,
count(*) as cnt
FROM `pr_mail_message` WHERE status = "sent" and DATE(`created_at`) > (CURDATE() - INTERVAL 1 MONTH) 
group by `email`,`at` order by `email`,`at`

SELECT `mail_config` as email, 
SUM(IF( DATE(`created_at`) = CURDATE(), 1, 0 )) AS today, 
SUM(IF( DATE(`created_at`) = (CURDATE() - INTERVAL 1 DAY), 1, 0 )) AS yesterday, 
SUM(IF( DATE(`created_at`) = (CURDATE() - INTERVAL 2 DAY), 1, 0 )) AS two_days_ago, 
count(*) as all_time, 
DATEDIFF(max(`created_at`),min(`created_at`))+1 as all_days, 
count(*)/(DATEDIFF(max(`created_at`),min(`created_at`))+1) as average_day 
FROM `pr_mail_message` WHERE status = "sent" group by `email` order by `email`

SELECT `mail_config` as email, 
SUM(IF( DATE(`at`) = CURDATE(), cnt, 0 )) AS today, 
SUM(IF( DATE(`at`) = (CURDATE() - INTERVAL 1 DAY), cnt, 0 )) AS yesterday, 
SUM(IF( DATE(`at`) = (CURDATE() - INTERVAL 2 DAY), cnt, 0 )) AS two_days_ago, 
sum(cnt) as all_time, 
DATEDIFF(max(`at`),min(`at`))+1 as all_days, 
sum(cnt)/(DATEDIFF(max(`at`),min(`at`))+1) as average_day 
FROM
(SELECT `mail_config` , DATE(`created_at`) as at,
count(*) as cnt
FROM `pr_mail_message` WHERE status = "sent"  
group by `mail_config`,`at` 
union 
SELECT `mail_config` , `at`, `cnt` FROM `pr_mail_sum`) t
group by `email` order by `email`
*/