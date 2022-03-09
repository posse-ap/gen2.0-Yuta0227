use webapp;
drop table if exists time;
create table time (
    date int,
    month int,
    year int,
    language varchar(255),
    content varchar(255),
    hours int,
    content_id int,
    language_id int
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
insert into time (date, month, year, language, content, hours, content_id,language_id) values 
    (5,3,2022, "PHP", "POSSE課題", 3,1,3),
    (4,3,2022, "SQL", "POSSE課題", 5,1,6),
    (23,5,2022, "PHP", "POSSE課題", 5,1,3),
    (20,3,2022,"Laravel","POSSE課題",18,1,5),
    (21,8,2022,"PHP","ドットインストール",9,2,3),
    (1,1,2022,"HTML","N予備校",5,3,4),
    (22,9,2022,"情報システム基礎知識(その他)","ドットインストール",4,2,8),
    (6,7,2022,"SHELL","N予備校",3,3,7),
    (9,6,2022,"PHP","ドットインストール",2,2,3),
    (19,4,2022,"Javascript","N予備校",5,3,1),
    (19,4,2022,"CSS","N予備校",5,3,2),
    (19,4,2022,"HTML","N予備校",5,3,4),
    (8,3,2022,"HTML","ドットインストール",8,2,4)
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