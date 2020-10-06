alter table questions
    add min_required_election int null
        comment 'Bu alan değerlendirmenin gerçekleşmesi için en az kaç değ. olacağına karar verir'
        after content_url;

alter table settings
    add min_elector_count int null after captcha_enabled;

alter table settings
    add max_elector_count int null after min_elector_count;


update settings set min_elector_count = 2, max_elector_count=5 where settings.min_elector_count IS NULL;