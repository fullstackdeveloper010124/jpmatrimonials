-> set base_url in file -> Y:\mega_matrimony\original_script\v2.0\application\config.php

-> set database name, username, password in file -> Y:\mega_matrimony\original_script\v2.0\application\database.php

-> set database name, username, password in file -> Y:\mega_matrimony\original_script\v2.0\freichat\hardcode.php


create crone in server
	-> set crone jobs time
	-> set crone jobs command : curl -silent https://www.mega-matrimony.narjisdemos.com/crone/send_bulk_email

-> Set 4 cron job:-

	1. Send Bulk Email:
		set minute :10
		curl -silent https://www.mega-	matrimony.narjisdemos.com/crone/send_bulk_email

	2. Send Bulk SMS:
		set minute :10
		curl -silent https://www.mega-	matrimony.narjisdemos.com/crone/send_bulk_sms

	3. logout for app:
		set minute :20
		curl -silent https://www.mega-matrimony.narjisdemos.com/Login/cron_job_logout

	4. Send Auto match
		set minute :20
		curl -silent https://www.mega-matrimony.narjisdemos.com/crone/send_matches_sms


-> Change App Id, App Secret key in - application\views\front_end\Facebook\Facebook.php  - ignore

-> Change Environment - production in index.php (Main Folder)

-> Change client id and web appkey in site_config table for ticket_managment system

-> set the domain path in assets/photots/htaccess and assets/photots_big/htaccess for image.

-> If installing SSL then, please update https in assets/photots/htaccess and assets/photots_big/htaccess file

