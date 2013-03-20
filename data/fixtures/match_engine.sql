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
    WHERE crit_desc.desc_question_id IS NOT NULL
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
    WHERE crit_desc.desc_question_id IS NOT NULL
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


DELIMITER ;;
CREATE PROCEDURE `generate_straight_matches`(IN member_id_param INT, IN max_score_param INT, IN file_name CHAR(200))
BEGIN
    SET @member_id = member_id_param;
    SET @max_score = max_score_param;

    SET @sql = CONCAT('SELECT ?, m2.id AS member2_id, 
              ROUND(SUM(
                    CASE dq.type
                        WHEN "radio" THEN IF( FIND_IN_SET(da.desc_answer_id, crit_desc.desc_answers), crit_desc.match_weight, 0)
                          WHEN "other_langs" THEN IF(ISNULL(da.custom), 0, crit_desc.match_weight)
                          WHEN "native_lang" THEN IF(m1.language = m2.language, match_weight, 0)
                          WHEN "select" THEN IF( da.desc_answer_id BETWEEN SUBSTRING_INDEX(crit_desc.desc_answers, ",", 1) AND SUBSTRING_INDEX(crit_desc.desc_answers, ",", -1), crit_desc.match_weight, 0)
                          WHEN "age" THEN IF(m2.age BETWEEN SUBSTRING_INDEX(crit_desc.desc_answers, ",", 1) AND SUBSTRING_INDEX(crit_desc.desc_answers, ",", -1), crit_desc.match_weight, 0)
                          ELSE 0
                      END
                      ) / ? * 100) AS pct
        INTO OUTFILE ', '"', file_name, '"', 
        ' FROM member AS m1 
        JOIN desc_question AS dq 
        CROSS JOIN member AS m2 ON ( m2.id != m1.id AND m1.looking_for = m2.sex AND m2.looking_for = m1.sex AND m2.member_status_id = 1 AND m1.id = ? )
        LEFT JOIN member_desc_answer AS da ON (da.member_id = m2.id AND da.desc_question_id = dq.id )
        LEFT JOIN search_crit_desc AS crit_desc ON (dq.id = crit_desc.desc_question_id AND m1.id = crit_desc.member_id )
        LEFT JOIN catalogue AS m1_catalog ON (m1.catalog_id = m1_catalog.cat_id )
        WHERE m2.catalog_id IN (m1_catalog.shared_catalogs) OR m1.catalog_id = m2.catalog_id
        GROUP BY m2.id');

    PREPARE stmt1 FROM @sql; 
    EXECUTE stmt1 USING @member_id, @max_score, @member_id;
    DEALLOCATE PREPARE stmt1;

END;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE `generate_reverse_matches`(IN member_id_param INT, IN max_score_param INT, IN file_name CHAR(200))
BEGIN
    SET @member_id = member_id_param;
    SET @max_score = max_score_param;

    SET @sql = CONCAT('SELECT m1.id AS member1_id, ?, 
              ROUND(SUM(
                    CASE dq.type
                        WHEN "radio" THEN IF( FIND_IN_SET(da.desc_answer_id, crit_desc.desc_answers), crit_desc.match_weight, 0)
                          WHEN "other_langs" THEN IF(ISNULL(da.custom), 0, crit_desc.match_weight)
                          WHEN "native_lang" THEN IF(m1.language = m2.language, match_weight, 0)
                          WHEN "SELECT" THEN IF( da.desc_answer_id BETWEEN SUBSTRING_INDEX(crit_desc.desc_answers, ",", 1) AND SUBSTRING_INDEX(crit_desc.desc_answers, ",", -1), crit_desc.match_weight, 0)
                          WHEN "age" THEN IF(m2.age BETWEEN SUBSTRING_INDEX(crit_desc.desc_answers, ",", 1) AND SUBSTRING_INDEX(crit_desc.desc_answers, ",", -1), crit_desc.match_weight, 0)
                          ELSE 0
                      END
                      ) / ? * 100) AS pct 
        INTO OUTFILE ', '"', file_name, '"', 
        ' FROM member AS m1 
        JOIN desc_question AS dq 
        CROSS JOIN member AS m2 ON ( m2.id = ? AND m2.id != m1.id AND m1.looking_for = m2.sex AND m2.looking_for = m1.sex AND m1.member_status_id = 1 )
        LEFT JOIN member_desc_answer AS da ON (da.member_id = m2.id AND da.desc_question_id = dq.id )
        LEFT JOIN search_crit_desc AS crit_desc ON (dq.id = crit_desc.desc_question_id AND m1.id = crit_desc.member_id )
        LEFT JOIN catalogue AS m1_catalog ON (m1.catalog_id = m1_catalog.cat_id )
        WHERE m2.catalog_id IN (m1_catalog.shared_catalogs) OR m1.catalog_id = m2.catalog_id
        GROUP BY m1.id');

    PREPARE stmt1 FROM @sql; 
    EXECUTE stmt1 USING @member_id, @max_score, @member_id;
    DEALLOCATE PREPARE stmt1;

END;;
DELIMITER ;
