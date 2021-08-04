-- This migration is primarily for improving and adding to the games tables.
-- However There were some quality of life changes to other tables too

-- Altered some columns on games
alter table games rename column bgg_id to genre_id;
alter table games alter column genre_id type bigint using genre_id::bigint;
alter table games add image_link text;

-- Added some foreign key constraints
alter table games add constraint games_expansion_fk foreign key (expansion_to) references games on update restrict on delete set null;
alter table games add constraint games_game_platforms_id_fk foreign key (game_platform_id) references game_platforms on update restrict on delete set null;
alter table games add constraint games_game_owners_id_fk foreign key (game_owner_id) references game_owners on update restrict on delete set null;

-- Added a boolean for use of buying whole packages
alter table barcodes add package boolean default false not null;

-- Genre table
create table game_genre
(
    id bigserial
        constraint game_genre_pk
            primary key,
    name varchar(255) not null,
    created_at timestamp(0) default current_timestamp,
    updated_at timestamp(0) default current_timestamp
);
create unique index game_genre_name_uindex on game_genre (name);

-- More foreign key constraints
alter table games add constraint games_game_genre_id_fk foreign key (genre_id) references game_genre on update restrict on delete set null;
alter table committee_members add constraint committee_members_active_years_id_fk foreign key (active_year_id) references active_years on update restrict on delete restrict;

-- Changed default value of updated_at & created_at to be current time and date
alter table accounts alter column created_at set default current_timestamp;
alter table accounts alter column updated_at set default current_timestamp;
alter table active_years alter column created_at set default current_timestamp;
alter table active_years alter column updated_at set default current_timestamp;
alter table barcodes alter column created_at set default current_timestamp;
alter table barcodes alter column updated_at set default current_timestamp;
alter table categories alter column created_at set default current_timestamp;
alter table categories alter column updated_at set default current_timestamp;
alter table committee_members alter column created_at set default current_timestamp;
alter table committee_members alter column updated_at set default current_timestamp;
alter table door_statuses alter column created_at set default current_timestamp;
alter table door_statuses alter column updated_at set default current_timestamp;
alter table events alter column created_at set default current_timestamp;
alter table events alter column updated_at set default current_timestamp;
alter table game_owners alter column created_at set default current_timestamp;
alter table game_owners alter column updated_at set default current_timestamp;
alter table game_platforms alter column created_at set default current_timestamp;
alter table game_platforms alter column updated_at set default current_timestamp;
alter table games alter column created_at set default current_timestamp;
alter table games alter column updated_at set default current_timestamp;
alter table password_resets alter column created_at set default current_timestamp;
alter table products alter column created_at set default current_timestamp;
alter table products alter column updated_at set default current_timestamp;
alter table purchase_histories alter column created_at set default current_timestamp;
alter table purchase_histories alter column updated_at set default current_timestamp;
alter table purchase_history_products alter column created_at set default current_timestamp;
alter table purchase_history_products alter column updated_at set default current_timestamp;
alter table telescope_entries alter column created_at set default current_timestamp;
alter table users alter column created_at set default current_timestamp;
alter table users alter column updated_at set default current_timestamp;