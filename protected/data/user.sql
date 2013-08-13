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



/**********add package, wallet, transaction********/
CREATE TABLE `package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `packageName` varchar(255) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `bbf`.`package` (`packageName`, `value`) VALUES ('Alpha package', '500');
INSERT INTO `bbf`.`package` (`packageName`, `value`) VALUES ('Beta package', '1500');
INSERT INTO `bbf`.`package` (`packageName`, `value`) VALUES ('Gamma package', '3500');

CREATE TABLE `wallet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `foodPoint` double NOT NULL,
  `userId` BIGINT(10) unsigned NOT NULL,
  `modifiedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_wallet_user_idx` (`userId`),
  CONSTRAINT `fk_wallet_user_idx` FOREIGN KEY (`userId`) REFERENCES `user` (`id`)
);

CREATE TABLE `transaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `walletId` int(10) unsigned NOT NULL,
  `tranType` enum('DEBIT','CREDIT') COLLATE utf8_bin NOT NULL,
  `amount` float(13,4) NOT NULL,
  `balance` float(13,4) DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `promoCode` varchar(6) COLLATE utf8_bin,
  `tranDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_wallet_idx` (`walletId`),
  CONSTRAINT `fk_transaction_wallet_idx` FOREIGN KEY (`walletId`) REFERENCES `wallet` (`id`)
);

/************add some column**********/
alter table user add password varchar(512) not null;
alter table user add bankAcc varchar(100) null;
alter table user add bankName varchar(50) null;
alter table user add pin int(6) null;
alter table wallet add bonusAmount double null;
alter table user add tac int(6) null;
alter table user add isApproved boolean default 0;
UPDATE `bbf`.`user` SET `isApproved`='1' WHERE `id`='1';

CREATE TABLE `announcement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`id`)
);

alter table announcement default character set utf8 collate utf8_bin;
alter table announcement convert to character set utf8 collate utf8_bin;


/****2013/7/31*******/
alter table package add column level int null;

UPDATE `bbf`.`package` SET `level`='2' WHERE `id`='1';
UPDATE `bbf`.`package` SET `level`='5' WHERE `id`='2';
UPDATE `bbf`.`package` SET `level`='10' WHERE `id`='3';


CREATE TABLE `sponsorlevel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` int not null,
  `rate` double not null,
  PRIMARY KEY (`id`)
);

INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('1', '0.075');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('2', '0.05');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('3', '0.04');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('4', '0.035');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('5', '0.03');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('6', '0.025');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('7', '0.015');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('8', '0.01');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('9', '0.01');
INSERT INTO `bbf`.`sponsorlevel` (`level`, `rate`) VALUES ('10', '0.01');

/*****20130808*****/
alter table user add column isActivated tinyint(1) default 0;
alter table wallet add column cashPoint double after foodPoint;

/*****20130813****/
create table withdrawal ( id int unsigned not null primary key auto_increment, walletId int unsigned not null, amount float(13,4) not null, balance float(13,4) not null, tranDate datetime not null, status tinyint(1) default 0 not null, foreign key(walletId) references wallet(id));