# Instagram-user-media
  Grabs all media and info about every user you add to "username.txt" file.
  This was part of a project for collecting info from instagram.
  <br/>When usernames are added this script can run on cronjob and everytime it runs it will check if there is new media for usernames, if there is no new media, it skips user and goes to next one.
  
  <hr>
  
  <h3> How to make this script work?</h3>
  <ol><li>Inside of username.php on line 6 you have to add your API access token to $access_token</li>
  <li>Inside of config.php you have to add info about mysql server( line 3 to 6 )</li>
  <li>Inside of username.txt you have to add every username you want to be scraped for data, users have to be public</li>
  <li>Import db.sql to your database</li></ol>
  
  If you want to recive email notification when script finished ( if you put it on cronjob ) you can check logs.txt or you can add your email address to username.php on line 7 and remove double slash from line 210 ( before mail command ) and you will recive email notification everytime script finishes.
  
