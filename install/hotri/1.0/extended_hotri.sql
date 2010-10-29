-- This file must be executed after core database & samples installed
ALTER TABLE %prfx%biblio ADD COLUMN has_cover char(1) DEFAULT 'N';
ALTER TABLE %prfx%member ADD COLUMN is_active char(1) DEFAULT 'Y';

ALTER TABLE %prfx%settings ADD COLUMN font_normal varchar(20) DEFAULT 'Garuda';
ALTER TABLE %prfx%settings ADD COLUMN font_bold varchar(20) DEFAULT 'Garuda-Bold';
ALTER TABLE %prfx%settings ADD COLUMN font_oblique varchar(20) DEFAULT 'Garuda-Oblique';


-- Defaults for bibliography picture (book cover) MARC field (902a) - ignore when exist
INSERT IGNORE INTO %prfx%usmarc_subfield_dm VALUES (902,'a','Bibliography Picture','N');
INSERT IGNORE INTO %prfx%usmarc_tag_dm VALUES (9,902,'Additional Fields','Undefined','Undefined','Y');
INSERT IGNORE INTO %prfx%usmarc_indicator_dm VALUES (902,1,'#','Undefined');
INSERT IGNORE INTO %prfx%usmarc_indicator_dm VALUES (902,2,'#','Undefined');


-- Settings for AWS account on book cover lookup
CREATE TABLE IF NOT EXISTS `cover_options` (
`aws_key` VARCHAR( 50 ) NULL DEFAULT NULL ,
`aws_secret_key` VARCHAR( 50 ) NULL DEFAULT NULL ,
`aws_account_id` VARCHAR( 50 ) NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `cover_options` (`aws_key`, `aws_secret_key`, `aws_account_id`) VALUES 
('', '', '');