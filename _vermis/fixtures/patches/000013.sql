-- Patch 000013

ALTER TABLE `user` MODIFY login VARCHAR(64);
ALTER TABLE `user` MODIFY name VARCHAR(128);
ALTER TABLE `user` MODIFY slug VARCHAR(128);
ALTER TABLE `user` MODIFY email VARCHAR(128);

ALTER TABLE project__issue MODIFY title VARCHAR(128);
ALTER TABLE project__issue MODIFY slug VARCHAR(128);
ALTER TABLE project__issue_version MODIFY title VARCHAR(128);

ALTER TABLE project__note MODIFY title VARCHAR(128);
ALTER TABLE project__note MODIFY slug VARCHAR(128);
ALTER TABLE project__note_version MODIFY title VARCHAR(128);
ALTER TABLE project__note_version MODIFY slug VARCHAR(128);

ALTER DATABASE CHARACTER SET utf8;
ALTER DATABASE COLLATE utf8_general_ci;

ALTER TABLE log CHARACTER SET utf8;
ALTER TABLE project CHARACTER SET utf8;
ALTER TABLE project__component CHARACTER SET utf8;
ALTER TABLE project__component_version CHARACTER SET utf8;
ALTER TABLE project__issue CHARACTER SET utf8;
ALTER TABLE project__issue__comment CHARACTER SET utf8;
ALTER TABLE project__issue__file CHARACTER SET utf8;
ALTER TABLE project__issue_version CHARACTER SET utf8;
ALTER TABLE project__member CHARACTER SET utf8;
ALTER TABLE project__milestone CHARACTER SET utf8;
ALTER TABLE project__milestone_version CHARACTER SET utf8;
ALTER TABLE project__note CHARACTER SET utf8;
ALTER TABLE project__note_version CHARACTER SET utf8;
ALTER TABLE project_version CHARACTER SET utf8;
ALTER TABLE `user` CHARACTER SET utf8;
ALTER TABLE version CHARACTER SET utf8;

UPDATE version SET version = 13;
