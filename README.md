# fastpaced_videos

Setting up your Youtube authorization credentials to make this work

1. Create your project and select the API Services
https://developers.google.com/youtube/registering_an_application
- Click the Credentials page link

2. Create a new project 
- Give it whatever name you want

3. On the "Google APIs" tab
- Search for "Youtube Data API v3"
- Click the link under the name column
- Click "enable" on the following screen

  note: it can take a few minutes for these changes to take effect so if you get errors put on your patience pants and hold tight

4. Get the Server key
- Click the "go to credentials" button (should show up after you enable the data api previously)
- You can then go through the "Find out what kind of credentials you need" wizard or you can just click the "Credentials" button in the left colum
- I chose the latter after which I clicked the "Create credentials" button and chose API key
- Then click "Server key"
- Give it a name, leave the IP address blank for this situation, and click "Create"

5. Add the key to the bottom of your `settings.php`

`$_SERVER['GGL_API_KEY'] = 'xxxxxxxxxxxxxxxxxxxxxxxxx';`

If all the magic works as it's supposed to you should be good to go. 

6. Have a martini

7. Give a friend a high five
