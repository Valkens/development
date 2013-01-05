--
-- Dumping data for table `engine4_core_modules`
--

INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('book', 'Books', 'Book store management', '1.0.0', 1, 'extra') ;

-- --------------------------------------------------------


--  --  --
-- Dumping data for table `engine4_book_books`
--

CREATE TABLE `engine4_book_books`(
`book_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` VARCHAR(128) NOT NULL,
`author` VARCHAR(128) NOT NULL,
`owner_type` VARCHAR(64) NOT NULL,
`owner_id` INT(11) unsigned NOT NULL,
`description` TEXT NOT NULL,
`photo_id` INT(11) unsigned NULL,
`posted_by` INT NOT NULL, `posted_date` DATETIME NOT NULL,
`price` DOUBLE(10,0) unsigned NOT NULL,
`view_count` int(11) unsigned NOT NULL default '0',
PRIMARY KEY (`book_id`) ) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- Dumping data for table `engine4_core_menus`
--

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
('book_main', 'standard', 'Book Main Navigation Menu') ;

-- --------------------------------------------------------


--
-- Dumping data for table `engine4_core_menuitems`
--

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('core_admin_main_plugins_book', 'book', 'Books', '', '{"route":"admin_default","module":"book","controller":"manage"}', 'core_admin_main_plugins', '', 999) ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_admin_main_manage', 'book', 'View Books', '', '{"route":"admin_default","module":"book","controller":"manage"}', 'book_admin_main', '', 1) ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_admin_main_level', 'book', 'Member Level Settings', '', '{"route":"admin_default","module":"book","controller":"level"}', 'book_admin_main', '', 2) ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_admin_main_transaction', 'book', 'Book transactions', '', '{"route":"admin_default","module":"book","controller":"transaction"}', 'book_admin_main', '', 3) ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('core_main_book', 'book', 'Books', '', '{"route":"book_general"}', 'core_main', '', 4) ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_main_browse', 'book', 'Browse All', '', '{"route":"book_general"}', 'book_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_main_manage', 'book', 'My Books', '', '{"route":"book_general","action":"manage"}', 'book_main', '', 2);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_main_add', 'book', 'Add a Book', '', '{"route":"book_general","action":"add"}', 'book_main', '', 3);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_main_cart', 'book', 'Cart', '', '{"route":"book_general","action":"cart"}', 'book_main', '', 4);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ('book_main_transaction', 'book', 'My Transactions', '', '{"route":"book_general","action":"transaction"}', 'book_main', '', 5);

-- --------------------------------------------------------

--


--
-- Dumping data for table `engine4_activity_actiontypes`
--

INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('book_new', 'book', '{item:$subject} posted a new book:', 1, 5, 1, 3, 1, 1);


-- --------------------------------------------------------

--
-- Dumping data for table `engine4_authorization_permissions`
--

-- ALL
-- auth_view, auth_comment, auth_html
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'auth_view' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'auth_comment' as `name`,
    5 as `value`,
    '["everyone","owner_network","owner_member_member","owner_member","owner"]' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'auth_html' as `name`,
    3 as `value`,
    'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr' as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN('public');

-- ADMIN, MODERATOR
-- create, delete, edit, view, comment, css, style, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'view' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'comment' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'style' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'max' as `name`,
    3 as `value`,
    1000 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');

-- USER
-- create, delete, edit, view, comment, css, style, max
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'comment' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'style' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'max' as `name`,
    3 as `value`,
    50 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');

-- PUBLIC
-- view
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'book' as `type`,
    'view' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('public');

-- --------------------------------------------------------

--


--
-- Dumping data for table `engine4_book_params`
--
CREATE TABLE IF NOT EXISTS `engine4_book_params` (
  `param_id` int(11) NOT NULL default '1',
  `search` varchar(256) default NULL,
  `orderby` varchar(50) NOT NULL,
  `show` tinyint(1) NOT NULL default '1',
  `page` int(11) default NULL,
  `date` datetime default NULL,
  `book_id` int(11) unsigned NULL,
  PRIMARY KEY  (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT IGNORE INTO `engine4_book_params` (`param_id`, `search`, `orderby`, `show`, `page`, `date`, `book_id`) VALUES
(1, '', '', 1, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `engine4_book_orders` (
  `order_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `owner_id` INT(11) UNSIGNED NOT NULL,
  `total` DOUBLE(10,2) UNSIGNED NOT NULL,
  `count` INT(5) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`orderdetail_id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `engine4_book_orderdetails` (
  `orderdetail_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `order_id` INT(11) UNSIGNED NOT NULL,
  `book_id` INT(11) UNSIGNED NOT NULL,
  `quantity` INT(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`orderdetail_id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;