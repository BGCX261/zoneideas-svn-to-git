-- --------------------------------------------------------

--
-- Table structure for table `zi_comments`
--

CREATE TABLE IF NOT EXISTS `zi_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `comment_text` text NOT NULL,
  `comment_date` int(11) NOT NULL default '0',
  `idea_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`)
) TYPE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `zi_ideas`
--

CREATE TABLE IF NOT EXISTS `zi_ideas` (
  `idea_id` int(10) unsigned NOT NULL auto_increment,
  `idea_title` varchar(255) NOT NULL default '',
  `idea_date` int(10) unsigned NOT NULL default '0',
  `idea_rate` int(10) NOT NULL default '0',
  `idea_desc` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`idea_id`)
) TYPE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `zi_rates`
--

CREATE TABLE IF NOT EXISTS `zi_rates` (
  `rate_id` int(11) NOT NULL auto_increment,
  `idea_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rate_id`),
  KEY `idea_id` (`idea_id`,`user_id`)
) TYPE=InnoDB;

-- --------------------------------------------------------

--
-- Table structure for table `zi_users`
--

CREATE TABLE IF NOT EXISTS `zi_users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `user_name` varchar(70) NOT NULL default '',
  `user_email` varchar(70) NOT NULL default '',
  `user_password` varchar(50) NOT NULL default '',
  `user_regdate` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=InnoDB;
