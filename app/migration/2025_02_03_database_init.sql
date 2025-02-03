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

create table if not exists computer
(
    id    int auto_increment primary key,
    name  varchar(255) not null,
    price int          not null,
    specs text         not null
);

create table if not exists booking
(
    id         int auto_increment primary key,
    user_id    int,
    code       int(6)   not null unique,
    computers  int      not null,
    start_time datetime not null,
    end_time   datetime not null,
    status     enum ('confirmed','canceled'),
    totalPrice decimal(10, 2),

    foreign key (user_id) references user (id) on delete cascade
);

create table if not exists booking_computer
(
    booking_id  int not null,
    computer_id int not null,
    primary key (booking_id, computer_id),
    foreign key (booking_id) references booking (id) on delete cascade,
    foreign key (computer_id) references computer (id) on delete cascade
);
