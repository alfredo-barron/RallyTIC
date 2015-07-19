--User poner un status para quien va registrar los integrantes
create table users(
  id serial primary key,
  username varchar(25) not null,
  email text not null,
  password varchar(32) not null,
  first_name text,
  last_name text,
  gender varchar(1),
  rol varchar(1),
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO users(username,email,password,rol) VALUES ('alfredobarron','alfreedobarron@gmail.com','afec8e3faf8cc984cf3e0060e73fb945','P'),('j2deme','j2deme@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','O');

--No más de 4 integrantes o individuales
create table teams(
  id serial primary key,
  name varchar(25) not null,
  password varchar(32) not null,
  status boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO teams(name,password) VALUES ('Alfa','1234'),('Beta','4321'),('Omega','1122'),('Zeta','5678'),('Gamma','5690');

create table team_user(
  id serial primary key,
  team_id int,
  user_id int,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

--Usuarios listos

create table events(
  id serial primary key,
  name text not null,
  description text not null,
  date_event date not null,
  hour_start text not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table questions(
  id serial primary key,
  message text,
  answer text,
  track text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table stations(
  id serial primary key,
  name text,
  lat text,
  lng text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

create table activities(
  id serial primary key,
  name text, --A,B,C
  station_id int, --Estacion
  question_id int, --Pregunta
  intents int --Numero de intentos
  time int, --No sobrepasar los 5 minutos
  penalty int, --Castigo
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
