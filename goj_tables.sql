CREATE TABLE IF NOT EXISTS `goj_problem` (
   `problem_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(255) NOT NULL,
   `content` TEXT NOT NULL,
   `calTimeout` int NOT NULL,
   `runTimeout` int NOT NULL,
   `input` TEXT NOT NULL,
   `output` TEXT NOT NULL,
   `spInput` TEXT NOT NULL,
   `spOutput` TEXT NOT NULL,
   `author` varchar(255) NOT NULL,
   `submitedC` int NOT NULL,
   `solvedC` int NOT NULL,
   PRIMARY KEY (`problem_id`)
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

CREATE TABLE IF NOT EXISTS `goj_statu` (
   `statu_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
   `problem_id` smallint(4) unsigned NOT NULL,
   `nick_name` varchar(255) NOT NULL,
   `user` varchar(255) NOT NULL,
   `result` varchar(255) NOT NULL default 'Queuing',
   `lang` varchar(255) NOT NULL,
   `use_time` int unsigned NOT NULL,
   `codeL` int unsigned NOT NULL,
   `time` timestamp NOT NULL default now(), 
   PRIMARY KEY (`statu_id`)
 )AUTO_INCREMENT=100000000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; 


CREATE TABLE IF NOT EXISTS `goj_feedback` (
   `feedback_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(255) unsigned NOT NULL,	
   `content` TEXT NOT NULL,
   `time` timestamp NOT NULL default now(), 
   PRIMARY KEY (`feedback_id`)
 )AUTO_INCREMENT=10000 ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; 