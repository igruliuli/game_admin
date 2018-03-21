## Sync rounds script ##

### Attempt to do with cron ###
` */6 * * * * /usr/bin/php /var/www/html/admin/yii sync-rounds` 
` * * * * * /usr/bin/php /var/www/html/admin/yii process-rounds` 
 
 
### Unstable implementation with daemon (lives ~ 3 hours and dies) ###
How to run on init
https://gist.github.com/naholyr/4275302

systemctl daemon-reload
/etc/init.d/process-rounds >/var/log/process-rounds.log 2>&1 &

Run in correct order
Look also command `insserv`
And https://wiki.debian.org/LSBInitScripts