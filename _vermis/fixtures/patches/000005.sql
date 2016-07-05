-- Patch 000005

ALTER TABLE project__issue__comment MODIFY content text;

UPDATE version SET version = 5;
