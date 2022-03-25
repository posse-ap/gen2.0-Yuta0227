use webapp;
drop table if exists time;
create table time (
    id int AUTO_INCREMENT,
    posted_at datetime default current_timestamp,
    date int,
    month int,
    year int,
    language varchar(255),
    content varchar(255),
    hours int,
    content_id int,
    language_id int,
    user_id int,
    primary key(id)
);
drop table if exists users;
create table users(
    user_id int AUTO_INCREMENT,
    user_type varchar(255),
    user_name varchar(255),
    user_password varbinary(200),
    user_email varchar(255),
    primary key(user_id)
);
insert into users (user_type,user_name,user_password) values ("管理者","root",AES_ENCRYPT("secret",'ENCRYPT-KEY'));
drop table if exists delete_request;
create table delete_request(
    id int AUTO_INCREMENT,
    delete_id int,
    delete_reason varchar(255),
    user_id int,
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