drop table if exists big_questions;
create table big_questions(
    id int auto_increment,
    name varchar(255),
    primary key(id)
);
insert into big_questions (id,name) values (1,"はい"),(2,"広島県の難読地名クイズ");

-- mysql -u root -p quizy < /docker-entrypoint-initdb.d/init.sqlでmysqlに反映可能