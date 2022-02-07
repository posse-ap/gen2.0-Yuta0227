drop database if exists quizy;
create database quizy;
use quizy;
drop table if exists big_questions;
drop table if exists questions;
drop table if exists choices;
drop table if exists mix;
create table big_questions (
    id int auto_increment,
    name varchar(255),
    primary key(id)
);
create table questions (
    id int auto_increment,
    big_question_id int,
    image varchar(255),
    primary key(id)
);
create table choices (
    id int auto_increment,
    question_id int,
    name varchar(255),
    valid int,
    primary key(id)
);
insert into big_questions (id,name) values (1,"東京の難読地名クイズ"),(2,"広島県の難読地名クイズ");
insert into questions (big_question_id,image) values (1,"takanawa.png"),(1,"kameido.png"),(2,"mukainada.png");
insert into choices (question_id,name,valid) values (1,"たかなわ",1),(1,"たかわ",0),(1,"こうわ",0),(2,"かめと",0),(2,"かめど",0),(2,"かめいど",1),(3,"むこうひら",0),(3,"むきひら",0),(3,"むかいなだ",1);
-- mysql -u root -p quizy < /docker-entrypoint-initdb.d/init.sqlでmysqlに反映可能