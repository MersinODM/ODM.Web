alter table questions
    add min_required_election int null
        comment 'Bu alan değerlendirmenin gerçekleşmesi için en az kaç değ. olacağına karar verir'
        after content_url;

alter table settings
    add min_elector_count int null after captcha_enabled;

alter table settings
    add max_elector_count int null after min_elector_count;


update settings set min_elector_count = 2, max_elector_count=10 where settings.min_elector_count IS NULL;

create table user_permitted_lesson
(
    user_id int unsigned null,
    lesson_id int unsigned null,
    creator_id int unsigned null,
    is_main bool null,
    created_at timestamp null,
    updated_at timestamp null,
    constraint user_permitted_lesson_pk
        primary key (user_id, lesson_id),
    constraint user_permitted_lesson_branches_id_fk
        foreign key (lesson_id) references branches (id),
    constraint user_permitted_lesson_users_id_fk
        foreign key (user_id) references users (id),
    constraint user_permitted_lesson_users_id_fk_2
        foreign key (creator_id) references users (id)
);

INSERT INTO user_permitted_lesson (user_id, lesson_id, is_main, created_at, updated_at)
SELECT u.id, u.branch_id, true, NOW(), NOW() from users as u;

INSERT INTO user_permitted_lesson (user_id, lesson_id,  is_main, created_at, updated_at)
SELECT u.id, 15, false, NOW(), NOW() FROM users as u
WHERE u.branch_id IN (5, 10);