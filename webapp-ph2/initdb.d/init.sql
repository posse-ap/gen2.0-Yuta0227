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
insert into time (date, month, year, language, content, hours) values 
    (5, 3, 2022, "PHP", "POSSE課題", 3),
    (4, 3, 2022, "PHP", "POSSE課題", 5),
    (23, 5, 2022, "PHP", "POSSE課題", 5),
    (20,3,2022,"PHP","POSSE課題",5),
    (5,3,2022,"PHP","POSSE課題",7)
    ;
-- update time set hours = concat
-- insert into time (date,month,year,language,content,hours) values 
-- (NULL,NULL,NULL,NULL,NULL,NULL)
-- declare @index integer
-- set @index = 1 
-- while @index <= 31 
-- BEGIN
-- select * from time where date=@index
-- if hours is NULL then set hours = 0
-- end if
-- set @index = @index + 1 
-- end
    -- dateの中にhoursを入れたい
    -- 事前にdateは用意しといてhoursに数値があったら取得。なかったら0を返すという処理を入れたい
    -- 理想は特定の日にちのhourがnullの場合0を返すこと
    -- 0を返さないと入力がないほど配列がくずれて
    -- mysql -u root -p webapp < /docker-entrypoint-initdb.d/init.sqlでも反映させることができる