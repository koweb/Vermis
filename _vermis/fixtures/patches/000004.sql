-- Patch 000004

CREATE TABLE project__note (
    id BIGINT AUTO_INCREMENT, 
    project_id BIGINT NOT NULL, 
    create_time BIGINT, 
    update_time BIGINT, 
    title VARCHAR(255) NOT NULL, 
    slug VARCHAR(255) NOT NULL, 
    content TEXT, 
    UNIQUE INDEX project__note_unique_idx_idx (project_id, slug, title), 
    FULLTEXT INDEX project__note_fts_idx_idx (title, slug, content), 
    INDEX project_id_idx (project_id), 
    PRIMARY KEY(id)
) ENGINE = MYISAM;

ALTER TABLE project__note 
    ADD CONSTRAINT project__note_project_id_project_id 
    FOREIGN KEY (project_id) REFERENCES project(id) ON DELETE CASCADE;

UPDATE version SET version = 4;
