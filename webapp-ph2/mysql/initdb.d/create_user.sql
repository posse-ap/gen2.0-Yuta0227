drop user if exists yuta;
create user 'yuta'@'%' identified by 'secret';
grant all privileges on * . * to 'yuta'@'%';