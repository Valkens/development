CREATE TABLE IF NOT EXISTS `engine4_blog_params` (
  `param_id` int(11) NOT NULL default '1',
  `search` varchar(256) default NULL,
  `orderby` varchar(50) NOT NULL,
  `show` tinyint(1) NOT NULL default '1',
  `category` int(11) NOT NULL,
  `page` int(11) default NULL,
  `tag` varchar(256) default NULL,
  `start_date` datetime default NULL,
  `end_date` datetime default NULL,
  `date` datetime default NULL,
  PRIMARY KEY  (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `engine4_blog_params` (`param_id`, `search`, `orderby`, `show`, `category`, `page`, `tag`, `start_date`, `end_date`, `date`) VALUES
(1, '', '', 0, 0, NULL, NULL, NULL, NULL, NULL);


CREATE TABLE  IF NOT EXISTS `engine4_blog_features` (
  `feature_id` int(11) unsigned NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL,
  `blog_good` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`feature_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS  `engine4_blog_becomes` (
`become_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`blog_id` INT( 11 ) NOT NULL DEFAULT '0',
`user_id` INT( 11 ) NOT NULL DEFAULT '0',
PRIMARY KEY ( `become_id` )
) ENGINE = InnoDB ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('blog_admin_main_addthis', 'blog', 'AddThis Settings', '', '{"route":"admin_default","module":"blog","controller":"addthis"}', 'blog_admin_main', '', 4);

UPDATE `engine4_core_modules` SET `version` = '4.05' WHERE `engine4_core_modules`.`name` = 'blog' LIMIT 1 ;

CREATE TABLE IF NOT EXISTS `engine4_blog_subscriptions` (
  `subscription_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `subscriber_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`subscription_id`),
  UNIQUE KEY `user_id` (`user_id`,`subscriber_user_id`),
  KEY `subscriber_user_id` (`subscriber_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
('blog_subscribed_new', 'blog', '{item:$subject} has posted a new blog entry: {item:$object}.', 0, '');

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('notify_blog_subscribed_new', 'blog', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]');

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('blog_gutter_report', 'blog', 'Report', 'Blog_Plugin_Menus', '{"route":"default","module":"core","controller":"report","action":"create","class":"buttonlink smoothbox icon_report"}', 'blog_gutter', '', 6),
('blog_gutter_style', 'blog', 'Edit Blog Style', 'Blog_Plugin_Menus', '{"route":"blog_general","action":"style","class":"smoothbox buttonlink icon_blog_style"}', 'blog_gutter', '', 7),
('blog_gutter_subscribe', 'blog', 'Subscribe', 'Blog_Plugin_Menus', '{"route":"default","module":"blog","controller":"subscription","action":"add","class":"buttonlink smoothbox icon_blog_subscribe"}', 'blog_gutter', '', 8);
