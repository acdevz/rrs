-- create schema
create database if not exists rrs;

-- create tables
create table if not exists USER(username varchar(50) primary key,first_name
varchar(50),last_name varchar(50),password varchar(50),gender char,age
int,mobile_no varchar(50),email varchar(50),city varchar(50),state
varchar(50),country varchar(20));

create table if not exists TRAIN(train_no int primary key, train_name
varchar(50), travel double, distance int, mon char(1), tue char(1), wed char(1), thu char(1), fri char(1),
sat char(1), sun char(1), f_sl float, f_3a float, f_2a float, f_1a float);

create table if not exists STATION(station_code varchar(10), station_name varchar(50), train_no int, arrival_time
time, hault int, departure_time time, dist int, day tinyint,
constraint foreign key(train_no) references TRAIN(train_no) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists TRAIN_STATUS(train_no int primary key, _1A varchar(10), _2A varchar(10),
 _3A varchar(10), _SL varchar(10), date date);

create table if not exists TICKET(ticket_id int primary key,username varchar(50),status varchar(10),
no_of_passengers int, train_no int, from varchar(10), to varchar(10), date date, fare float, 
constraint foreign key(username) references USER(username) ON UPDATE CASCADE ON DELETE CASCADE,
constraint foreign key(train_no) references TRAIN(train_no) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists PASSENGER(passenger_id int primary key,pnr_no char(11), name varchar(50),
age int,gender char,username varchar(50), seat_no varchar(5), ticket_id int,
constraint foreign key(username) references USER(username) ON UPDATE CASCADE ON DELETE CASCADE,
constraint foreign key(ticket_id) references TICKET(ticket_id)ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists STARTS( train_no int primary key, station_no
int, constraint foreign key(train_no) references TRAIN(train_no), constraint foreign
key(station_no) references STATION(station_no));

create table if not exists STOPS( train_no int primary key, station_no
int, constraint foreign key(train_no) references TRAIN(train_no) ON UPDATE CASCADE ON DELETE CASCADE, constraint foreign
key(station_no) references STATION(station_no) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists REACHES(train_no int,station_no int,time
time, constraint foreign key(train_no) references TRAIN(train_no) ON UPDATE CASCADE ON DELETE CASCADE,
constraint foreign key(station_no) references STATION(station_no) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists BOOKS(username varchar(50),ticket_id int,constraint foreign key(username)
references USER(username) ON UPDATE CASCADE ON DELETE CASCADE, constraint foreign key(ticket_id) references TICKET(ticket_id) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists CANCEL(username varchar(50), ticket_id int, passenger_id int,constraint
foreign key(ticket_id) references TICKET(ticket_id) ON UPDATE CASCADE ON DELETE CASCADE,constraint foreign key(passenger_id)
references PASSENGER(passenger_id) ON UPDATE CASCADE ON DELETE CASCADE,constraint foreign key(username) references
USER(username) ON UPDATE CASCADE ON DELETE CASCADE);

-- insert prepared data
insert into TRAIN 
values
	(12587, 'AMARNATH EXP', 22.40, 1248, 'Y','x','x','x','x','x','x', 0.46, 1.22, 1.70, 3.00),
	(12379, 'JALIANWALA B EX', 27.10, 1894, 'x','x','x','x','x','x','Y', 0.4, 1.20, 1.5, 2.8);

insert into STATION (station_code, name, train_no, arrival_time, departure_time, hault, dist, day)
values
    ('GKP', 'Gorakhpur', '12578', '14:20', '14:20', 0, 0, 1),
    ('KLD', 'Khalilabad', '12578', '14:54', '14:56', 2, 35, 1),
    ('BST', 'Basti', '12578', '15:19', '15:22', 3, 65, 1),
    ('GD', 'Gonda Jn', '12578', '16:45', '16:55', 10, 154, 1),
    ('LKO', 'Lucknow', '12578', '19:20', '19:30', 10, 271, 1),
    ('SPN', 'Shahjehanpur (PQ)', '12578', '22:20', '22:22', 2, 435, 1),
    ('BE', 'Bareilly', '12578', '23:21', '23:23', 2, 506, 1),
    ('MB', 'Moradabad', '12578', '00:57', '01.05', 8, 597, 2),
    ('LRJ', 'Laksar Jn', '12578', '02:54', '02:56', 2, 736, 2),
    ('RK', 'Roorkee', '12578', '03:16', '03:18', 2, 754, 2),
    ('SRE', 'Saharanpur', '12578', '04:15', '04:25', 10, 789, 2),
    ('YJUD', 'Yamunanagar Jagadhri', '12578', '04:51', '04:53', 2, 819, 2),
    ('UMB', 'Ambala Cant Jn', '12578', '05:45', '05:50', 5, 870, 2),
    ('LDH', 'Ludhiana Jn', '12578', '07:26', '07:36', 10, 984, 2),
    ('JRC', 'Jalandhar Cant', '12578', '08:24', '08:29', 5, 1036, 2),
    ('PTKC', 'Pathankot Cantt', '12578', '10:30', '10:35', 5, 1149, 2),
    ('KTHU', 'Kathua', '12578', '11:04', '11:06', 2, 1172, 2),
    ('JAT', 'Jammu Tawi', '12578', '13:00', '13:00', 0, 1248, 2),
    
	('ASR', 'Amritsar Jn', 12380, '0', '13:25', 0, 1, 1),
    ('BEAS', 'Beas', 12380, '13:53', '13:55', 2, 43, 1),
    ('JUC', 'Jalandhar City', 12380, '14:30', '14:35', 5, 79, 1),
    ('LDH', 'Ludhiana Jn', 12380, '15:30', '15:38', 8, 136, 1),
    ('UMB', 'Ambala Cant Jn', 12380, '17:15', '17:25', 10, 250, 1),
    ('DLI', 'Delhi (RL)', 12380, '20:00', '20:15', 15, 447, 1),
    ('CNB', 'Kanpur Central', 12380, '01:10', '01:15', 5, 880, 2),
    ('DDU', 'Dd Upadhyaya Jn', 12380, '06:10', '06:20', 10, 1227, 2),
    ('SSM', 'Sasaram', 12380, '07:18', '07:20', 2, 1327, 2),
    ('GAYA', 'Gaya Jn', 12380, '08:40', '08:45', 5, 1430, 2),
    ('KQR', 'Koderma', 12380, '09:54', '09:56', 2, 1508, 2),
    ('DHN', 'Dhanbad Jn', 12380, '11:37', '11:42', 5, 1629, 2),
    ('KMME', 'Kumardubi', 12380, '12:28', '12:29', 1, 1668, 2),
    ('ASN', 'Asansol Jn', 12380, '12:53', '13:03', 10, 1688, 2),
    ('DGR', 'Durgapur', 12380, '13:35', '13:37', 2, 1730, 2),
    ('BWN', 'Barddhaman', 12380, '14:33', '14:35', 2, 1793, 2),
    ('SDAH', 'Sealdah', 12380, '16:35', '0', 0, 1894, 2);
    
insert into TRAIN_STATUS 
values
	(12380, 'AVL05', 'AVL02', 'AVL01', 'GNWL2', '2023-12-10'),
	(12380, 'AVL02', 'AVL03', 'GNWL02', 'GNWL12', '2023-12-17');
-- ... 


