/* Updating procedures */
DROP PROCEDURE IF EXISTS update_matches;
delimiter //
CREATE PROCEDURE update_matches(IN member_id_param INT, IN max_weight_param INT)
BEGIN
    DECLARE max_score INT;
    SELECT COUNT(*)*max_weight_param INTO max_score FROM desc_question;
    
    DELETE FROM member_match WHERE member1_id = member_id_param;
    INSERT INTO member_match (member1_id, member2_id, pct )
  SELECT member_id_param, m2.id AS member2_id,
    ROUND(SUM(match_score(dq.type, da.desc_answer_id, crit_desc.desc_answers, da.custom, m1.language, m2.language, crit_desc.match_weight )) / max_score * 100) AS pct
    FROM member AS m1 
    JOIN desc_question AS dq 
    CROSS JOIN member AS m2 ON ( m2.id != m1.id AND m1.looking_for = m2.sex AND m2.member_status_id = 1 AND m1.id = member_id_param )
    LEFT JOIN member_desc_answer AS da ON (da.member_id = m2.id AND da.desc_question_id = dq.id )
    LEFT JOIN search_crit_desc AS crit_desc ON (dq.id = crit_desc.desc_question_id AND m1.id = crit_desc.member_id )
    GROUP BY m2.id;
END;
//
delimiter ;

DROP PROCEDURE IF EXISTS update_matches_all;
delimiter //
CREATE PROCEDURE update_matches_all(IN max_weight_param INT)
BEGIN
    DECLARE max_score INT;
    SELECT COUNT(*)*max_weight_param INTO max_score FROM desc_question;
    
  DELETE FROM member_match;
  INSERT INTO member_match (member1_id, member2_id, pct)
  SELECT m1.id, m2.id AS member2_id,
    ROUND(SUM(match_score(dq.type, da.desc_answer_id, crit_desc.desc_answers, da.custom, m1.language, m2.language, crit_desc.match_weight )) / max_score * 100) AS pct
    FROM member AS m1
    JOIN desc_question AS dq 
    CROSS JOIN member AS m2 ON ( m2.id != m1.id AND m1.looking_for = m2.sex AND m2.member_status_id = 1 )
    LEFT JOIN member_desc_answer AS da ON (da.member_id = m2.id AND da.desc_question_id = dq.id )
    LEFT JOIN search_crit_desc AS crit_desc ON (dq.id = crit_desc.desc_question_id AND m1.id = crit_desc.member_id )
    GROUP BY m1.id, m2.id;
END;
//
delimiter ;


/* Score Calculating function */
DROP FUNCTION IF EXISTS match_score;
delimiter //
CREATE FUNCTION match_score(dq_type VARCHAR(11), da_answer_id INT, crit_desc_answers VARCHAR(200), da_custom TEXT, m1_lang CHAR(2), m2_lang CHAR(2), match_weight INT )
RETURNS INTEGER
DETERMINISTIC
BEGIN
    DECLARE age INT;
    DECLARE birthday DATE;
    
    IF dq_type = 'age' THEN
     SET birthday = CAST(da_custom AS DATE);
    SET age = IF( MONTH(CURRENT_DATE) < MONTH(birthday) OR ( (MONTH(CURRENT_DATE) = MONTH(birthday)) AND DAY(CURRENT_DATE) < DAY(birthday) ), 
      YEAR(CURRENT_DATE) - YEAR(birthday) -1, 
      YEAR(CURRENT_DATE) - YEAR(birthday));
    END IF;
    
    RETURN CASE dq_type
    WHEN 'radio' THEN IF( FIND_IN_SET(da_answer_id, crit_desc_answers), match_weight, 0)
  WHEN 'other_langs' THEN IF(ISNULL(da_custom), 0, match_weight)
  WHEN 'native_lang' THEN IF(m1_lang = m2_lang, match_weight, 0)
  WHEN 'select' THEN IF( da_answer_id BETWEEN SUBSTRING_INDEX(crit_desc_answers, ',', 1) AND SUBSTRING_INDEX(crit_desc_answers, ',', -1), match_weight, 0)
  WHEN 'age' THEN IF(age BETWEEN SUBSTRING_INDEX(crit_desc_answers, ',', 1) AND SUBSTRING_INDEX(crit_desc_answers, ',', -1), match_weight, 0)
  ELSE 0
  END;
END//
delimiter ;

/*Last action function */
DROP FUNCTION IF EXISTS last_action;
delimiter //
CREATE FUNCTION last_action(m1_id INT, m2_id INT)
RETURNS CHAR(2)
DETERMINISTIC
BEGIN
  DECLARE last_action CHAR(2);
  DECLARE last_action_time DATETIME;
  
  DECLARE c CURSOR FOR
    (SELECT IF(msg.sent_box = 1, "SM", "RM") AS last_action, msg.created_at FROM message AS msg 
      WHERE (msg.from_member_id = m1_id AND msg.to_member_id = m2_id AND msg.sent_box = 1) 
      OR (msg.from_member_id = m2_id AND msg.to_member_id = m1_id AND msg.sent_box = 0) 
      ORDER BY msg.created_at DESC LIMIT 1) 
    UNION 
    (SELECT IF(wink.sent_box = 1, "SW", "RW") AS last_action, wink.created_at FROM wink 
      WHERE (wink.member_id = m1_id AND wink.profile_id = m2_id AND wink.sent_box = 1) 
      OR (wink.member_id = m2_id AND wink.profile_id = m1_id AND wink.sent_box = 0) 
      ORDER BY wink.sent_box ASC LIMIT 1)
    ORDER BY created_at DESC LIMIT 1;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' BEGIN END;
  
  OPEN c;
  FETCH c INTO last_action, last_action_time;
  CLOSE c;
  
  RETURN last_action;
END//

delimiter ;
