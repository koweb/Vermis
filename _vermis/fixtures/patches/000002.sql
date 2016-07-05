-- Patch 000002

ALTER TABLE project MODIFY description text;
ALTER TABLE project__component MODIFY description text;
ALTER TABLE project__issue MODIFY description text;
ALTER TABLE project__milestone MODIFY description text;

UPDATE version SET version = 2;
