create table users(
  id serial primary key,
  username text not null,
  email text not null,
  password text not null,
  first_name text,
  last_name text,
  gender varchar(1),
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table events(
  id serial primary key,
  name text not null,
  description text not null,
  date_event date not null,
  hour_start text not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);


create table activities(
  id serial primary key,
  name text not null,
  question text not null,
  track text not null,
  request text not null,
  lat text,
  long text,
  time int not null,
  status boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table activity_event(
  id serial primary key,
  event_id int not null,
  activity_id int not null,
  order_activity int,
  start_activity boolean default false,
  end_activity boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (event_id) references events(id),
  foreign key (activity_id) references activities(id)
);

create table login_logout(
  id serial primary key,
  user_id int not null,
  lat text,
  lng text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (user_id) references users(id)
);

create table event_user(
  id serial primary key,
  event_id int not null,
  user_id int not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (event_id) references events(id),
  foreign key (user_id) references users(id)
);

create table bitacora(
  id serial primary key,
  user_id int not null,
  activity_id int not null,
  event_id int not null,
  lat text not null,
  lng text not null,
  hour text not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (user_id) references users(id),
  foreign key (event_id) references events(id),
  foreign key (activity_id) references activities(id)
);
