CREATE DATABASE slim;

CREATE TABLE `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `head` varchar(255) DEFAULT NULL,
  `neck` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `feet` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb4;