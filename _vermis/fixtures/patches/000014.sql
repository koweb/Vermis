-- Patch 000014

UPDATE project__issue SET priority = 5 WHERE priority = 2;
UPDATE project__issue SET priority = 4 WHERE priority = 1;
UPDATE project__issue SET priority = 3 WHERE priority = 0;
UPDATE project__issue SET priority = 2 WHERE priority = -1;
UPDATE project__issue SET priority = 1 WHERE priority = -2;

UPDATE version SET version = 14;
