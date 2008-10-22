CREATE TABLE group_and_action (
    "action" character varying(200) NOT NULL,
    group_id integer NOT NULL
);

ALTER TABLE ONLY group_and_action
    ADD CONSTRAINT pk_new_sec_perm PRIMARY KEY ("action", group_id);

ALTER TABLE ONLY group_and_action
    ADD CONSTRAINT new_sec_perms_group_id_fkey FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE;