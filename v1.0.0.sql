alter table exams
    change status_id status int unsigned not null;

alter table exams
    add date_of_occurrence datetime null after planned_date;

alter table exams
    add purpose_id int null after creator_id;

alter table exams
    add path varchar(255) null after date_of_occurrence;


alter table exams
    add code varchar(50) null after purpose_id;

create table exam_purposes
(
    id         int          not null,
    purpose    varchar(500) not null,
    code       varchar(50)  null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint exam_purposes_pk
        primary key (id)
);

INSERT INTO exam_purposes (id, purpose, code, created_at, updated_at)
VALUES (1, 'Araştırma Sınavı', 'ARAS', null, null);
INSERT INTO exam_purposes (id, purpose, code, created_at, updated_at)
VALUES (2, 'Pilotlama Sınavı', 'PİLS', null, null);
INSERT INTO exam_purposes (id, purpose, code, created_at, updated_at)
VALUES (3, 'MEB Merkezi Sınavı', 'MEBS', null, null);

alter table branches
    add class_levels varchar(200) null after code;
UPDATE branches
SET class_levels = "4,5,6,7,8"
WHERE id IN (1, 2, 3, 5);

UPDATE branches
SET class_levels = "4,5,6,7,8,9,10,11,12"
WHERE id IN (4, 12);

UPDATE branches
SET class_levels = "9,10,11,12"
WHERE id IN (6, 7, 8, 9, 10, 11, 13, 14);

UPDATE branches
SET class_levels = "8,12"
WHERE id = 15;
