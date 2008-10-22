CREATE SEQUENCE groups_seq INCREMENT BY 1 MINVALUE 1 NO MAXVALUE START WITH 1;

CREATE TABLE groups (
    id serial,
    group_name character varying(100) NOT NULL,
    group_description character varying(1000)
);

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);

ALTER TABLE ONLY groups
    ADD CONSTRAINT un_group_name UNIQUE (group_name);