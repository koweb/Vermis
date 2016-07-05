-- Patch 000009

CREATE TABLE `project__issue_version` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `project_id` bigint(20) NOT NULL,
  `milestone_id` bigint(20) DEFAULT NULL,
  `component_id` bigint(20) DEFAULT NULL,
  `create_time` bigint(20) DEFAULT NULL,
  `update_time` bigint(20) DEFAULT NULL,
  `reporter_id` bigint(20) DEFAULT NULL,
  `assignee_id` bigint(20) DEFAULT NULL,
  `changer_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `type` varchar(16) NOT NULL DEFAULT 'task',
  `priority` bigint(20) NOT NULL DEFAULT '0',
  `status` varchar(32) NOT NULL DEFAULT 'opened',
  `progress` bigint(20) NOT NULL DEFAULT '0',
  `version` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`version`)
) ENGINE=MyISAM;

ALTER TABLE project__issue ADD COLUMN changer_id bigint(20);
ALTER TABLE project__issue ADD COLUMN version bigint(20);

UPDATE version SET version = 9;
