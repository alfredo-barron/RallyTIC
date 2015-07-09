--User poner un status para quien va registrar los integrantes
create table users(
  id serial primary key,
  username varchar(25) not null,
  email text not null,
  password varchar(32) not null,
  first_name text,
  last_name text,
  gender varchar(1),
  admin boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO users(username,email,password,admin) VALUES ('alfredobarron','alfreedobarron@gmail.com','afec8e3faf8cc984cf3e0060e73fb945',true),('j2deme','j2deme@gmail.com','827ccb0eea8a706c4c34a16891f84e7b',true);

--No más de 4 integrantes o individuales
create table teams(
  id serial primary key,
  name text not null,
  password text,
  user_id int,
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
  name text, --A,B,C
  message text,
  request text,
  lat text,
  long text,
  intents int
  time int, --No sobrepasar los 5 minutos
  penalty int,
  track text,
  status boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table activity_event(
  id serial primary key,
  event_id int not null,
  activity_id int not null,
  team_id int not null,
  order_activity int, --Puede cambiar para cada equipo 1,2,3,4,5,6
  start_activity boolean default false, --Siempre seran las mismas
  end_activity boolean default false, --Siempre seran las mismas
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

--Aqui sera las ubicaciones constantes
create table login_logout(
  id serial primary key,
  user_id int not null,
  lat text,
  lng text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table event_team(
  id serial primary key,
  event_id int not null,
  team_id int not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (event_id) references events(id),
  foreign key (team_id) references teams(id)
);
--Pendiente
create table bitacora(
  id serial primary key,
  team_id int not null,
  activity_id int not null,
  event_id int not null,
  lat text not null,
  lng text not null,
  time text not null,

  created_at timestamp not null default now(),
  updated_at timestamp not null default now(),
  foreign key (user_id) references users(id),
  foreign key (event_id) references events(id),
  foreign key (activity_id) references activities(id)
);
