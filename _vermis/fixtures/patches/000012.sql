-- Patch 000012

CREATE TABLE `project__note_version` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `project_id` bigint(20) NOT NULL,
  `create_time` bigint(20) DEFAULT NULL,
  `update_time` bigint(20) DEFAULT NULL,
  `author_id` bigint(20) DEFAULT NULL,
  `changer_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `version` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`version`)
) ENGINE=MyISAM;

ALTER TABLE project__note ADD COLUMN author_id bigint(20);
ALTER TABLE project__note ADD COLUMN changer_id bigint(20);
ALTER TABLE project__note ADD COLUMN version bigint(20);

UPDATE version SET version = 12;
