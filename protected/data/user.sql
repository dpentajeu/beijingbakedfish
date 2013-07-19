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
