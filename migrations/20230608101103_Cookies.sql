create table cookie (
    name varchar(200) default '' not null,
    value varchar(200) default '',
    expires varchar(200) default '',
    shop varchar(200) default '' not null,
    primary key(name, shop)
);