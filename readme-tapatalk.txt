  = Tapatalk Kunena Plugin =

- Make installation package for Joomla!
	Get into the plg_system_tapatalk folder,compress all the files in the folder to plg_system_tapatalk.zip package.
  
- Installation:	
	At First,please uninstall the old tapatalk plugin version for kunena in Joomla! admin panel,and delete the mobiquo folder,and continue the following steps!
	1. Upload mobiquo folder to your Joomla! root folder.You should make the files under the mobiquo folder can be accessed directly through browser,otherwise the plugin may would not work.
	2. In your Joomla! admin panel, go to Extensions > Extension Manager.
	3. Select plg_system_tapatalk.zip under 'Upload Package File'.
	4. Click Upload & Install
	5. Go to Extensions > Plug-In Manager and search 'Tapatalk' using the Filter box.
	6. Click the red icon to enable Tapatalk Kunena Plugin if it is not already enabled.


- Kunena 2.0 Series Version 1.0.0 released

1.support kunena 2.0.1/2.0.2
2.substantially modified the plugin development framework for easy using on plugin development
3.fixed some compatibility issues in different Joomla! version for example Joomla! 1.5.x/2.5.x 
4.fixed bug:can not get the correct attaments in the first post of topic
5.support upload/delete attachment
6.support edit post(get_raw_post/save_raw_post)
7.support get_online_users
8.support subscribe_forum/unsubscribe_forum/subscribe_topic/unsubscribe_topic
9.support get_user_topic/get_user_reply_post
10.support is_deleted flag for topic and post
11.support is_sticky/is_closed flag for topic
12.support subscribe flags for forum and topic:is_subscribed/can_subscribed
13.fixed bug:return wrong quoted user name when get quote post content
14.modify:not include sticky topics when get standard forum topics in get_topic method
15.return correct new_post flag when get topic data
16.optimize color convert
17.optimize output
18.optimize bbcode support
19.fixed some other bugs

For more important update info please visit:
http://support.tapatalk.com/threads/tapatalk-for-kunena-plugin-release-announcement-and-changelog.6632

20120919
