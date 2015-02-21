CREATE TABLE IF NOT EXISTS `goj_conpro` (
   `conpro_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
   `pid` smallint(4) unsigned NOT NULL,
   `cid` int unsigned NOT NULL,
   `title` varchar(255) NOT NULL,
   `content` TEXT NOT NULL,
   `calTimeout` int NOT NULL,
   `runTimeout` int NOT NULL,
   `input` TEXT NOT NULL,
   `output` TEXT NOT NULL,
   `spInput` TEXT NOT NULL,
   `spOutput` TEXT NOT NULL,
   `author` varchar(255) NOT NULL,
   `ac` int NOT NULL,
   `pe` int NOT NULL,
   `wa` int NOT NULL,
   `tle` int NOT NULL,
   `ce` int NOT NULL,
   `total` int NOT NULL,
   PRIMARY KEY (`conpro_id`)
 ) AUTO_INCREMENT=1000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `goj_user` (
   `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
   `account` varchar(255) NOT NULL,
   `password` varchar(255) NOT NULL,
   `solvedC` int NOT NULL,
   `submitedC` int NOT NULL,
   `solvedP` varchar(255) NOT NULL,
   `unsolvedP` varchar(255) NOT NULL,
   `nick_name` varchar(255) NOT NULL,
   `school` varchar(255) NOT NULL,
   `qq` varchar(255) NOT NULL,
   PRIMARY KEY (`user_id`)
 ) AUTO_INCREMENT=1000000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `goj_cstatu` (
   `cstatu_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
   `problem_id` smallint(4) unsigned NOT NULL,
   `cid` int unsigned NOT NULL,
   `nick_name` varchar(255) NOT NULL,
   `user` varchar(255) NOT NULL,
   `result` varchar(255) NOT NULL default 'Queuing',
   `lang` varchar(255) NOT NULL,
   `use_time` int unsigned NOT NULL,
   `codeL` int unsigned NOT NULL,
   `time` timestamp NOT NULL default now(), 
   PRIMARY KEY (`cstatu_id`)
 )AUTO_INCREMENT=10000000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; 

CREATE TABLE IF NOT EXISTS `goj_contest` (
   `contest_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `start_time` timestamp NOT NULL,
   `end_time` timestamp NOT NULL,
   `type` varchar(255) NOT NULL,
   `status` varchar(255) NOT NULL,
   `adder` varchar(255) NOT NULL,
   PRIMARY KEY (`contest_id`)
 )AUTO_INCREMENT=100000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `goj_crank` (
   `crank_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
   `cid` int unsigned NOT NULL,
   `user` varchar(255) NOT NULL,
   `team` varchar(255) NOT NULL,
   `lastS` int NOT NULL default 0,
   `solvedC` int unsigned NOT NULL,
   `penatly` int NOT NULL,
   `solvedP` varchar(255) NOT NULL,
   `unsolvedP` varchar(255) NOT NULL,
   PRIMARY KEY (`crank_id`)
 )AUTO_INCREMENT=100000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;