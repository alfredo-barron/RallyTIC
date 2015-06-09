create table users(
  id serial primary key,
  username text not null,
  email text not null,
  password text not null,
  birthdate date not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table activity_rally(
  id serial primary key,
  rally_id int not null,
  activity_id int not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table rallies(
  id serial primary key,
  name text not null,
  description text not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);


create table activities(
  id serial primary key,
  name text not null,
  type int not null,
  key text not null,
  question text,
  lat text,
  long text,
  status boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

