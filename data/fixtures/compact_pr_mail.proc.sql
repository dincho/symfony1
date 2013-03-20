DELIMITER ;;

CREATE DEFINER=`root`@`localhost` PROCEDURE `compact_pr_mail`()
BEGIN
  START TRANSACTION;
    INSERT INTO pr_mail_sum( mail_config, at, cnt)
      SELECT mail_config , DATE(created_at) as at,
      count(*) as cnt
      FROM pr_mail_message WHERE status = "sent" and DATE(created_at) < (CURDATE() - INTERVAL 1 MONTH) 
      group by mail_config,at order by mail_config,at;
    DELETE FROM pr_mail_message WHERE DATE(created_at) < (CURDATE() - INTERVAL 1 MONTH);
  COMMIT;
END;;
DELIMITER ;
