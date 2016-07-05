-- Patch 000015

ALTER TABLE project__issue DROP INDEX project__issue_fts_idx_idx;

ALTER TABLE project__issue MODIFY title VARCHAR(255);
ALTER TABLE project__issue MODIFY slug VARCHAR(255);

ALTER TABLE project__issue ADD FULLTEXT INDEX project__issue_fts_idx_idx (title, slug);

ALTER TABLE project__issue_version MODIFY title VARCHAR(255);

UPDATE version SET version = 15;
