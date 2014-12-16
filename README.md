storybot
========
When users send a snap to the snapchat account linked here, the bot will upload the received snap to its Story if it is approved by the moderation team.

First created by http://www.reddit.com/u/bicycle for /r/trees, but it can be used for anything.

To automatically upload all snaps received, you need to run a Cron job for some interval that performs "curl http://www.site.com/bot.php". Also run a Cron job for every hour (or some interval) to reset the limit @ hour_reset.php.

Moderate by going to /mod.php.

Please remember to edit the /config/config.php file!

Supports videos and images.

Requires cURL & PHP5-cURL module
