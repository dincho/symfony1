CREATE TABLE permissions (
    id integer NOT NULL,
    group_id integer NOT NULL
);

ALTER TABLE ONLY permissions
    ADD CONSTRAINT pk_permission PRIMARY KEY (id, group_id);

ALTER TABLE ONLY permissions
    ADD CONSTRAINT permission_group_id_fkey FOREIGN KEY (group_id) REFERENCES groups(id);
