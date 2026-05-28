CREATE DATABASE koroknet
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE koroknet;

CREATE TABLE users (
    id int auto_increment primary key,
    full_name varchar(63) not null,
    `login` varchar(127) not null unique,
    `password` varchar(511) not null,
    phone varchar(15) not null,
    email varchar(127) not null
);

CREATE TABLE leads (
    id int AUTO_INCREMENT not null primary key,
    user_id int not null,
    status varchar(63) not null default 'Новая',
    `start_date` date not null,
    name_course varchar(255) not null,
    payment_method varchar(255) not null,
    foreign key (user_id) references users(id)
);

CREATE TABLE reviews (
    id int AUTO_INCREMENT not null primary key,
    user_id int not null,
    lead_id int not null,
    stars int not null,
    review_text text not null,
    foreign key (user_id) references users(id),
    foreign key (lead_id) references leads(id)
)