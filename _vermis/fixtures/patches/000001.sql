-- Patch 000001

CREATE TABLE version (
    version int NOT NULL DEFAULT 0,
    PRIMARY KEY (version)
);
INSERT INTO version (version) VALUES (1);

