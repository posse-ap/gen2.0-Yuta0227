drop table if exists test;
create table test (
    id int,
    name varchar(255),
    time int
);
-- mysql -u root -p webapp < /docker-entrypoint-initdb.d/init.sqlでも反映させることができる
