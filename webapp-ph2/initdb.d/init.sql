use webapp;
drop table if exists time;
create table time (
    date int,
    month int,
    year int,
    language varchar(255),
    content varchar(255),
    hours int
);
insert into time (date,month,year,language,content,hours) values 
(4,3,2022,"PHP","POSSE課題",3),
(4,3,2022,"PHP","POSSE課題",5),
(23,5,2022,"PHP","POSSE課題",5);
-- mysql -u root -p webapp < /docker-entrypoint-initdb.d/init.sqlでも反映させることができる
