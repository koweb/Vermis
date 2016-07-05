-- Patch 000008

CREATE TABLE `project_version` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `author_id` bigint(20) DEFAULT NULL,
  `changer_id` bigint(20) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `description` text,
  `create_time` bigint(20) DEFAULT NULL,
  `update_time` bigint(20) DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `version` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`version`)
) ENGINE=MyISAM;

ALTER TABLE project ADD COLUMN changer_id bigint(20);
ALTER TABLE project ADD COLUMN version bigint(20);

UPDATE version SET version = 8;
