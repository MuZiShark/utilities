CREATE TABLE `student` ( 
  `id` int(11) NOT NULL auto_increment, 
  `name` varchar(50) NOT NULL, 
  `sex` varchar(10) NOT NULL, 
  `age` smallint(3) NOT NULL default '0', 
  PRIMARY KEY  (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 