use webapp;
drop table if exists time;
create table time (
    id int AUTO_INCREMENT,
    updated_at datetime default current_timestamp,
    date int,
    month int,
    year int,
    language varchar(255),
    content varchar(255),
    hours float,
    content_id int,
    language_id int,
    primary key(id)
);
drop table if exists users;
create table users(
    id auto_increment,
    user_type varchar(255),
    user_name varchar(255),
    user_password varchar(255),
    primary key(id)
);
-- content_id=
-- 1=>POSSE課題
-- 2=>ドットインストール
-- 3=>N予備校
-- language_id=
-- 1=>Javascript
-- 2=>CSS
-- 3=>PHP
-- 4=>HTML
-- 5=>Laravel
-- 6=>SQL
-- 7=>SHELL
-- 8=>情報システム基礎知識(その他)

    -- mysql -u root -p webapp < /docker-entrypoint-initdb.d/init.sqlでも反映させることができる