drop table if exists test;
create table test (
    id int,
    name varchar(255)
);
-- mysql -u root -p webapp < /docker-entrypoint-initdb.d/init.sql
