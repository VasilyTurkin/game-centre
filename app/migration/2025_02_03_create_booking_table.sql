use game_centre;

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
