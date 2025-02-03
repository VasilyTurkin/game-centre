use game_centre;

create table if not exists computer
(
    id    int auto_increment primary key,
    name  varchar(255) not null,
    price int          not null,
    specs text         not null
);
