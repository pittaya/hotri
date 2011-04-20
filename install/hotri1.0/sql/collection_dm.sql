drop table if exists %prfx%collection_dm;
create table %prfx%collection_dm (
  code smallint auto_increment primary key
  ,description varchar(40) not null
  ,default_flg char(1) not null
  ,days_due_back tinyint unsigned not null
  ,daily_late_fee decimal(4,2) not null
)
  TYPE=MyISAM DEFAULT CHARSET=utf8
;
