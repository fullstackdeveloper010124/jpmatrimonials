SELECT `ip`,`country`,`visit_time`,`page_name` FROM `user_analysis` group by ip ORDER BY `id` desc

===============================================================

DELIMITER $$
CREATE TRIGGER `update_ip_summary` AFTER INSERT ON `user_analysis` FOR EACH ROW BEGIN

 	SET @tableIp= (SELECT ip FROM user_analytics_summary where ip=NEW.ip LIMIT 1);
    
	    
    IF  (@tableIp!='') THEN
    
    	SET @tableBlock= (SELECT blocked FROM user_analytics_summary where ip=NEW.ip LIMIT 1);
        
    	update user_analytics_summary set ip = NEW.ip,country=NEW.country,visit_time=NEW.visit_time,page_name=NEW.page_name,blocked=@tableBlock where ip=NEW.ip;
    ELSE
        insert into user_analytics_summary (ip,country,visit_time,page_name,blocked) values (NEW.ip,NEW.country,NEW.visit_time,NEW.page_name,'NO');
    END IF;
   
   
   
END
$$
DELIMITER ;