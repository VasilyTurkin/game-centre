use game_centre;

create table if not exists booking_computer
(
    booking_id  int not null,
    computer_id int not null,
    primary key (booking_id, computer_id),
    foreign key (booking_id) references booking (id) on delete cascade,
    foreign key (computer_id) references computer (id) on delete cascade
);
