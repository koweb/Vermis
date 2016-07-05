-- Patch 000003

ALTER TABLE user ADD COLUMN email_notify tinyint(1) DEFAULT 1;

UPDATE version SET version = 3;
