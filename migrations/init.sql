create table rides
(
    id          uuid                     not null
        primary key,
    rider_id    uuid                     not null,
    departure   varchar(255)             not null,
    arrival     varchar(255)             not null,
    price       double precision         not null
);

