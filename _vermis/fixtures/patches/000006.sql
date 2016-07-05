-- Patch 000006

ALTER TABLE log MODIFY message text;
ALTER TABLE log MODIFY params text;

UPDATE version SET version = 6;
