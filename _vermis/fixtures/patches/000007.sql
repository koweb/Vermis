-- Patch 000007

ALTER TABLE project ADD COLUMN is_private tinyint(1) NOT NULL DEFAULT 0;

UPDATE version SET version = 7;
