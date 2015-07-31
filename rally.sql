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

INSERT INTO users(username,email,password,rol) VALUES ('alfredobarron','alfreedobarron@gmail.com','afec8e3faf8cc984cf3e0060e73fb945','P'),('j2deme','j2deme@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','O'),('nitgard','nitgard.zapata@tecvalles.mx','ef6299c9e7fdae6d775819ce1e2620b8','O');

create table teams(
  id serial primary key,
  name varchar(25) not null,
  password varchar(32) not null,
  status boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO teams(name,password) VALUES ('Alfa','1234'),('Beta','4321'),('Omega','1122'),('Zeta','5678'),('Gamma','5690'),('Equipo ITV','prueba');

create table team_user(
  id serial primary key,
  team_id int,
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

INSERT INTO events(name,description,date_event,hour_start) VALUES ('La fantastica aventura','Vamos a buscar las esferas del dragón',2015-07-24,'15:00'),('Evento de Prueba','Prueba del sistema',2015-07-25,'08:00');
)

create table questions(
  id serial primary key,
  message text,
  answer text,
  track text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO questions (message,answer,track) VALUES ('Esfera del dragón de 1 estrella','1','Una'),('Esfera del dragón de 2 estrellas','2','Dos'),('¿De qué color es el caballo blanco de Napoleon?','Blanco','#FFFFFF');

create table stations(
  id serial primary key,
  name text,
  lat text,
  lng text,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO stations (name,lat,lng) VALUES ('Estacionamiento del CINVESTAV','23.720849550243056','-99.07793238759041'),('Fuente del CINVESTAV','23.720553649386304','-99.07794445753098'),('Tec Valles','22.021999431637663','-99.03582572937012'),('Casa Victoria','23.745316830149086','-99.15129834786057');

create table activities(
  id serial primary key,
  name text,
  station_id int,
  question_id int,
  intents int,
  time int,
  penalty boolean default false,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO activities (name,station_id,question_id,intents,time,penalty) VALUES ('Actividad A',2,1,2,1,1),('Actividad B',1,2,0,0,0),('Actividad Valles',3,3,5,5,1),('Actividad Prueba',4,2,2,0,1);

create table activity_event(
  id serial primary key,
  event_id int not null,
  activity_id int not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO activity_event(event_id,activity_id) VALUES (1,1),(1,2),(2,1),(2,1),(1,4);

create table event_team(
  id serial primary key,
  event_id int not null,
  team_id int not null,
  created_at timestamp not null default now(),
  updated_at timestamp not null default now()
);

INSERT INTO event_team(event_id,team_id) VALUES (1,1),(2,6),(2,1),(2,2),(2,1),(6,2);
