use game_centre;

create table if not exists user
(
    id            int auto_increment primary key,
    login         varchar(255) not null,
    email         varchar(255) not null,
    password_hash varchar(255) not null,
    username      varchar(255),
    deposit       int
);
