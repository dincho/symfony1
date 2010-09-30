DROP FUNCTION IF EXISTS last_subscription_id_on;
delimiter //
CREATE FUNCTION last_subscription_id_on(id int, cur_date date)
RETURNS int
DETERMINISTIC
BEGIN
 DECLARE result int ;
 SELECT s.id INTO result
               FROM subscription_history AS s
               WHERE id = s.member_id AND cur_date BETWEEN DATE(COALESCE(s.from_date, "2009-01-28")) AND DATE(s.created_at)
               ORDER BY s.created_at DESC LIMIT 1;
 RETURN result;
END//
delimiter ;