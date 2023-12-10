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

create table if not exists STARTS( train_no int primary key, station_code
varchar(10), constraint foreign key(train_no) references TRAIN(train_no), constraint foreign
key(station_code) references STATION(station_code));

create table if not exists STOPS( train_no int primary key, station_code
varchar(10), constraint foreign key(train_no) references TRAIN(train_no) ON UPDATE CASCADE ON DELETE CASCADE, constraint foreign
key(station_code) references STATION(station_code) ON UPDATE CASCADE ON DELETE CASCADE);

create table if not exists CANCEL(username varchar(50), ticket_id int, passenger_id int,constraint
foreign key(ticket_id) references TICKET(ticket_id) ON UPDATE CASCADE ON DELETE CASCADE,constraint foreign key(passenger_id)
references PASSENGER(passenger_id) ON UPDATE CASCADE ON DELETE CASCADE,constraint foreign key(username) references
USER(username) ON UPDATE CASCADE ON DELETE CASCADE);

-- insert prepared data
insert into TRAIN 
values
	(12587, 'AMARNATH EXP', 22.40, 1248, 'Y','x','x','x','x','x','x', 0.46, 1.22, 1.70, 3.00),
	(12379, 'JALIANWALA B EX', 27.10, 1894, 'x','x','x','x','x','x','Y', 0.4, 1.20, 1.5, 2.8),
    (13006, 'ASR HWH MAIL', 37.05, 1910, 'Y','Y','Y','Y','Y','Y','Y', 0.5, 1.30, 1.75, 3.20),
    (19614,	'ASR AII EXP', '12.45', 848, 'x', 'x', 'x', 'x', 'Y', 'x', 'Y', 0.5, 1.3, 1.75, 3.2),
    (12318, 'AKAL TAKHAT EXP', '32.55', 1894, 'x', 'T', 'x', 'x', 'Y', 'x', 'x', 0.4, 1.5, 1.85, 3.5 );

insert into STATION (station_code, name, train_no, arrival_time, departure_time, hault, dist, day)
values
    ('GKP', 'Gorakhpur', 12578, '14:20', '14:20', 0, 0, 1),
    ('KLD', 'Khalilabad', 12578, '14:54', '14:56', 2, 35, 1),
    ('BST', 'Basti', 12578, '15:19', '15:22', 3, 65, 1),
    ('GD', 'Gonda Jn', 12578, '16:45', '16:55', 10, 154, 1),
    ('LKO', 'Lucknow', 12578, '19:20', '19:30', 10, 271, 1),
    ('SPN', 'Shahjehanpur (PQ)', 12578, '22:20', '22:22', 2, 435, 1),
    ('BE', 'Bareilly', 12578, '23:21', '23:23', 2, 506, 1),
    ('MB', 'Moradabad', 12578, '00:57', '01.05', 8, 597, 2),
    ('LRJ', 'Laksar Jn', 12578, '02:54', '02:56', 2, 736, 2),
    ('RK', 'Roorkee', 12578, '03:16', '03:18', 2, 754, 2),
    ('SRE', 'Saharanpur', 12578, '04:15', '04:25', 10, 789, 2),
    ('YJUD', 'Yamunanagar Jagadhri', 12578, '04:51', '04:53', 2, 819, 2),
    ('UMB', 'Ambala Cant Jn', 12578, '05:45', '05:50', 5, 870, 2),
    ('LDH', 'Ludhiana Jn', 12578, '07:26', '07:36', 10, 984, 2),
    ('JRC', 'Jalandhar Cant', 12578, '08:24', '08:29', 5, 1036, 2),
    ('PTKC', 'Pathankot Cantt', 12578, '10:30', '10:35', 5, 1149, 2),
    ('KTHU', 'Kathua', 12578, '11:04', '11:06', 2, 1172, 2),
    ('JAT', 'Jammu Tawi', 12578, '13:00', '13:00', 0, 1248, 2),
    
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

    ('ASR', 'Amritsar Jn', 13006, '00:00', '18:25', 0, 64, 1),
    ('BEAS', 'Beas', 13006, '18:53', '18:55', 2, 107, 1),
    ('KRE', 'Kartarpur', 13006, '19:13', '19:14', 1, 79, 1),
    ('JUC', 'Jalandhar City', 13006, '19:32', '19:40', 8, 84, 1),
    ('JRC', 'Jalandhar Cant', 13006, '19:49', '19:51', 2, 100, 1),
    ('PGW', 'Phagwara Jn', 13006, '20:03', '20:05', 2, 136, 1),
    ('LDH', 'Ludhiana Jn (RL)', 13006, '20:40', '20:50', 10, 222, 1),
    ('RPJ', 'Rajpura Jn', 13006, '22:06', '22:08', 2, 250, 1),
    ('UMB', 'Ambala Cant Jn', 13006, '23:00', '23:10', 10, 301, 1),
    ('YJUD', 'Yamunanagar Jagadhri', 13006, '23:45', '23:50', 5, 331, 1),
    ('SRE', 'Saharanpur', 13006, '00:45', '00:55', 10, 366, 2),
    ('RK', 'Roorkee', 13006, '01:37', '01:39', 2, 384, 2),
    ('LRJ', 'Laksar Jn', 13006, '01:58', '02:00', 2, 425, 2),
    ('NBD', 'Najibabad Jn', 13006, '02:36', '02:38', 2, 447, 2),
    ('NGG', 'Nagina', 13006, '02:58', '03:00', 2, 464, 2),
    ('DPR', 'Dhampur', 13006, '03:16', '03:18', 2, 523, 2),
    ('MB', 'Moradabad (RL)', 13006, '04:53', '04:58', 5, 551, 2),
    ('RMU', 'Rampur', 13006, '05:25', '05:27', 2, 614, 2),
    ('BE', 'Bareilly', 13006, '06:21', '06:23', 2, 685, 2),
    ('SPN', 'Shahjehanpur', 13006, '07:29', '07:31', 2, 747, 2),
    ('HRI', 'Hardoi', 13006, '08:24', '08:26', 2, 780, 2),
    ('BLM', 'Balamau Jn', 13006, '08:53', '08:55', 2, 849, 2),
    ('LKO', 'Lucknow (RL)', 13006, '10:35', '10:40', 5, 896, 2),
    ('BCN', 'Bachhrawn', 13006, '11:33', '11:34', 1, 927, 2),
    ('RBL', 'Rae Bareli Jn', 13006, '12:05', '12:10', 5, 956, 2),
    ('JAIS', 'Jais', 13006, '12:34', '12:35', 1, 974, 2),
    ('GNG', 'Gauriganj', 13006, '12:51', '12:53', 2, 987, 2),
    ('AME', 'Amethi', 13006, '13:07', '13:08', 1, 1022, 2),
    ('MBDP', 'Ma Belhadevi Dp', 13006, '13:45', '13:50', 5, 1059, 2),
    ('BSE', 'Badshahpur', 13006, '14:23', '14:25', 2, 1075, 2),
    ('JNH', 'Janghai Jn', 13006, '14:46', '14:48', 2, 1106, 2),
    ('BOY', 'Bhadohi', 13006, '15:21', '15:23', 2, 1150, 2),
    ('BSB', 'Varanasi Jn (RL)', 13006, '16:50', '17:00', 10, 1156, 2),
    ('KEI', 'Kashi', 13006, '17:12', '17:13', 1, 1167, 2),
    ('DDU', 'Dd Upadhyaya Jn', 13006, '17:55', '18:05', 10, 1211, 2),
    ('ZNA', 'Zamania', 13006, '18:43', '18:45', 2, 1225, 2),
    ('DLN', 'Dildarnagar Jn', 13006, '18:58', '19:00', 2, 1241, 2),
    ('GMR', 'Gahmar', 13006, '19:14', '19:16', 2, 1261, 2),
    ('BXR', 'Buxar', 13006, '19:32', '19:34', 2, 1277, 2),
    ('ARA', 'Ara', 13006, '20:23', '20:25', 2, 1330, 2),
    ('DNR', 'Danapur', 13006, '21:00', '21:02', 2, 1369, 2),
    ('PNBE', 'Patna Jn (RL)', 13006, '21:30', '21:40', 10, 1379, 2),
    ('PNC', 'Patna Saheb', 13006, '21:55', '22:00', 5, 1389, 2),
    ('BKP', 'Bakhtiyarpur Jn', 13006, '22:28', '22:30', 2, 1424, 2),
    ('MKA', 'Mokameh Jn', 13006, '23:05', '23:10', 5, 1468, 2),
    ('KIUL', 'Kiul Jn', 13006, '23:48', '23:50', 2, 1502, 2),
    ('JAJ', 'Jhajha', 13006, '01:23', '01:28', 5, 1556, 3),
    ('JSME', 'Jasidih Jn', 13006, '02:00', '02:05', 5, 1600, 3),
    ('MDP', 'Madhupur Jn', 13006, '02:30', '02:34', 4, 1629, 3),
    ('CRJ', 'Chittaranjan', 13006, '03:12', '03:14', 2, 1685, 3),
    ('ASN', 'Asansol Jn', 13006, '03:58', '04:03', 5, 1710, 3),
    ('RNG', 'Raniganj', 13006, '04:19', '04:21', 2, 1728, 3),
    ('DGR', 'Durgapur', 13006, '04:39', '04:41', 2, 1752, 3),
    ('BWN', 'Barddhaman', 13006, '05:45', '05:49', 4, 1816, 3),
    ('HWH', 'Howrah Jn', 13006, '07:30', '00:00', 0, 1910, 3),

    ('ASR', 'Amritsar Jn', '19614', '00:00', '17:45', 0, 43, 1),
    ('BEAS', 'Beas', '19614', '18:13', '18:15', 2, 79, 1),
    ('JUC', 'Jalandhar City', '19614', '18:52', '18:57', 5, 100, 1),
    ('PGW', 'Phagwara Jn', '19614', '19:15', '19:17', 2, 136, 1),
    ('LDH', 'Ludhiana Jn', '19614', '20:02', '20:12', 10, 181, 1),
    ('MET', 'Malerkotla', '19614', '20:48', '20:50', 2, 198, 1),
    ('DUI', 'Dhuri Jn', '19614', '21:25', '21:35', 10, 214, 1),
    ('SAG', 'Sangrur', '19614', '21:48', '21:50', 2, 264, 1),
    ('JHL', 'Jakhal Jn', '19614', '22:37', '22:40', 3, 346, 2),
    ('HSR', 'Hisar', '19614', '23:55', '00:15', 20, 406, 2),
    ('BNW', 'Bhiwani', '19614', '01:15', '01:20', 5, 433, 2),
    ('CKD', 'Charkhi Dadri', '19614', '01:43', '01:45', 2, 488, 2),
    ('RE', 'Rewari', '19614', '02:50', '02:55', 5, 536, 2),
    ('KRH', 'Khairthal', '19614', '03:28', '03:30', 2, 562, 2),
    ('AWR', 'Alwar Jn', '19614', '03:50', '03:53', 3, 598, 2),
    ('RHG', 'Rajgarh', '19614', '04:21', '04:23', 2, 610, 2),
    ('BU', 'Baswa', '19614', '04:35', '04:37', 2, 623, 2),
    ('BKI', 'Bandikui Jn', '19614', '04:49', '04:51', 2, 652, 2),
    ('DO', 'Dausa', '19614', '05:13', '05:15', 2, 702, 2),
    ('GTJT', 'Getor Jagatpura', '19614', '05:50', '05:52', 2, 708, 2),
    ('GADJ', 'Gandhinagar Jaipur', '19614', '06:02', '06:05', 3, 713, 2),
    ('JP', 'Jaipur', '19614', '06:30', '06:40', 10, 822, 2),
    ('KSG', 'Kishangarh', '19614', '08:00', '08:02', 2, 822, 2),
    ('AII', 'Ajmer Jn', '19614', '09:00', '00:00', 0, 848, 2),

    ('ASR', 'Amritsar Jn', '12318', '00:00', '05:55', 0, 0, 1),
    ('BEAS', 'Beas', '12318', '06:23', '06:25', 2, 43, 1),
    ('JUC', 'Jalandhar City', '12318', '07:02', '07:07', 5, 79, 1),
    ('LDH', 'Ludhiana Jn', '12318', '08:02', '08:12', 10, 136, 1),
    ('SIR', 'Sirhind Jn', '12318', '09:09', '09:11', 2, 196, 1),
    ('UMB', 'Ambala Cant Jn', '12318', '10:00', '10:05', 5, 250, 1),
    ('SRE', 'Saharanpur', '12318', '11:20', '11:25', 5, 331, 1),
    ('NBD', 'Najibabad Jn', '12318', '13:04', '13:06', 2, 425, 1),
    ('MB', 'Moradabad (RL)', '12318', '14:52', '15:00', 8, 523, 1),
    ('BE', 'Bareilly', '12318', '16:20', '16:22', 2, 614, 1),
    ('LKO', 'Lucknow (RL)', '12318', '20:05', '20:15', 10, 849, 1),
    ('SLN', 'Sultanpur Jn', '12318', '22:11', '22:13', 2, 989, 1),
    ('BSB', 'Varanasi Jn', '12318', '00:40', '00:50', 10, 1132, 2),
    ('DDU', 'Dd Upadhyaya Jn', '12318', '02:15', '02:25', 10, 1149, 2),
    ('PNBE', 'Patna Jn', '12318', '05:35', '05:45', 10, 1361, 2),
    ('PNC', 'Patna Saheb', '12318', '06:00', '06:05', 5, 1371, 2),
    ('MKA', 'Mokameh Jn', '12318', '07:04', '07:06', 2, 1450, 2),
    ('KIUL', 'Kiul Jn', '12318', '07:56', '08:00', 4, 1484, 2),
    ('JAJ', 'Jhajha', '12318', '09:00', '09:05', 5, 1538, 2),
    ('JSME', 'Jasidih Jn', '12318', '09:37', '09:39', 2, 1582, 2),
    ('MDP', 'Madhupur Jn', '12318', '10:04', '10:06', 2, 1611, 2),
    ('ASN', 'Asansol Jn', '12318', '11:18', '11:28', 10, 1692, 2),
    ('KOAA', 'Kolkata', '12318', '14:50', '00:00', 0, 1894, 2);

insert into STARTS
values
    (12578, 'GKP'),
    (13006, 'ASR'),
    (12379, 'ASR'),
    (19614, 'ASR'),
    (12318, 'ASR');
insert into STOPS
values
    (12578, 'JAT'),
    (13006, 'HWH'),
    (12379, 'SDAH'),
    (19614, 'AII'),
    (12318, 'KOAA');

insert into TRAIN_STATUS 
values
	(12380, 'AVL05', 'AVL02', 'AVL01', 'GNWL2', '2023-12-10'),
	(12380, 'AVL02', 'AVL03', 'GNWL02', 'GNWL12', '2023-12-17');
    (13006, 'AVL4', 'AVL11', 'AVL2', 'AVL4', '2023-12-10'),
    (13006, 'GNWL3', 'AVL8', 'AVL2', 'NO_AVL', '2023-12-18');