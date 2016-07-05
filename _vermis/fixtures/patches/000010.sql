-- Patch 000010

CREATE TABLE `project__milestone_version` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `slug` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `project_id` bigint(20) DEFAULT NULL,
  `create_time` bigint(20) DEFAULT NULL,
  `update_time` bigint(20) DEFAULT NULL,
  `author_id` bigint(20) DEFAULT NULL,
  `changer_id` bigint(20) DEFAULT NULL,
  `version` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`version`)
) ENGINE=MyISAM;

ALTER TABLE project__milestone ADD COLUMN author_id bigint(20);
ALTER TABLE project__milestone ADD COLUMN changer_id bigint(20);
ALTER TABLE project__milestone ADD COLUMN version bigint(20);

UPDATE version SET version = 10;
