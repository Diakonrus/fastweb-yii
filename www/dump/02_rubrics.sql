ALTER TABLE `tbl_article_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_baners_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_catalog_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description`  text NULL AFTER `title`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_doctor_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description`  text NULL AFTER `title`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_faq_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_news_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_photo_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_review_rubrics`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`,
ADD COLUMN `description_short`  text NULL AFTER `description`;


ALTER TABLE `tbl_press_group`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`;


ALTER TABLE `tbl_sale_group`
ADD COLUMN `title`  varchar(250) NULL AFTER `name`;