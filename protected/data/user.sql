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

/****************Add column**************/
alter table user modify dateOfBirth date null;
alter table user modify address varchar(255) null;
alter table user add referral int not null;
alter table user add packageId int not null;
insert into user values (1,'','BBF','info@beijingbakedfish.com','062815070','',null,null,20130701000000,20130701000000,0,0);
