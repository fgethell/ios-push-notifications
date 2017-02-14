# ios-push-notifications

This project is an iOS Push notification system using APNS (Apple Push Notification System) and also stores the token ID's into a database. The notifications can be automated with the help of Facebook Graph API, which posts a notification if theres a new post in the facebook group.

1. sql query.txt : Fire up this query to create a table in database, having columns ID (Auto incremental, unique) and token, which will store the token id generated on app installation.

2. iospush.php : This script uses the parameter "token" to insert values into the database created above. Use this link "http://yourdomainhere/iospush.php?token="inserttokenhere" in your iOS app to insert tokens generated into the database.

3. iosnotif.php : This is the main script which pushes the notification after connecting to Apple Server (APNS) and using SSL certificates and initializing curl request, notifications are generated to all the token ids stored in the db in step 2.

4. fbcheck.php : This script is executed every 30 minutes with the help of crontab feature of linux. Every 30 mins, it checks the id stored in the graph api json. If the id is new (new post in fb group), notification is generated, that is, "iosnotif.php" is executed.

5. To use the crontab feature, make sure it is installed in your linux distributary. To add your script to crontab list, simply do: 

root@username: crontab -e 
Press enter, now go into the edit mode of the crontab file by pressing "i". In the first line, just add:

*/30 * * * * lynx http://yourdomainhere/fbcheck.php
Press escape and type :wq, press enter and its done. fbcheck.php will be executed every 30 minutes.
