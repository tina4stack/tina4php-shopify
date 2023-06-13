create table session (
    shop varchar(200) default '',
    session_id varchar(200) default '',
    session_data blob,
    primary key (shop)
)