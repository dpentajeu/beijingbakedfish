DROP TABLE IF EXISTS `binarytree`;
CREATE TABLE IF NOT EXISTS `binarytree` (
	`id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
	`userId` bigint(10) unsigned NOT NULL,
	`level` int(10) unsigned NOT NULL,
	`created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	CONSTRAINT `fk_binarytree_user` FOREIGN KEY (`userId`) REFERENCES `user`(`id`)
);
-- Formula to insert a node
-- insert into binarytree (user_id, level) values (1, floor(log2(last_insert_id() + 1)) + 1)