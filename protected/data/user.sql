create database bbf;

use bbf;

CREATE  TABLE user (
  `id` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`acc_num` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `contact` VARCHAR(45) NOT NULL ,
	`address` VARCHAR(255) NOT NULL ,
	`dateOfBirth` date NOT NULL ,
	`country` int NULL ,
  `created` DATETIME NOT NULL ,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) );