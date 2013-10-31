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

--Script to query user that langgan more than twice
select * from (select walletId, count(walletId) as cnt from transaction where trandate >= '2013-10-01' and description rlike 'Deduct Redemption Point' group by walletId) t where t.cnt>1;