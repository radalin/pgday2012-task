--Define the meta data
--Order is important when you are creating an enum you know. The one written first becomes before the others...
create type task_status as enum ('late', 'open', 'done');

create table tasks (
    id serial primary key,
    name varchar(255),
    description text,
    end_date timestamp,
    status task_status default 'open'
);

--Define the data data (data data? WTF?)
insert into tasks (name, description, status, end_date) values ('PgDay icin kodu hazirla', 'Yapacagin sunum icin kodu hazir et ve Github uzerinden sun', 'done', '2012-05-11');
insert into tasks (name, description, status, end_date) values ('PgDay oncesi yemek', 'Hagander ile tasinacagin yemege git', 'late', '2012-05-11');
insert into tasks (name, description, status, end_date) values ('PgDay icin blog yaz', 'Super gecen PgDay Turkiye hakkinda bir blog yazisi yaz', 'open', '2012-05-19');
insert into tasks (name, description, status) values ('MySQL projelerini PgSQLe gecirmeye basla', 'Dogru yolu bulmanin vakti geldi.', 'open');