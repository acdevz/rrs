-- insert into TRAIN_STATUS values
-- (12380, 'AVL05', 'AVL02', 'AVL01', 'GNWL2', '2023-12-10'),
-- (12380, 'AVL02', 'AVL03', 'GNWL02', 'GNWL12', '2023-12-17');

-- select 
-- T.train_no as 'no',
-- T.train_name as 'name',
-- S1.station_code as 'from',
-- date_add(TS.date, interval (S1.day - 1) day) as 'from_date',
-- time_format(S1.departure_time, '%H:%i') as 'from_time',
-- S2.station_code as 'to',
-- date_add(TS.date, interval (S2.day - 1) day) as 'to_date',
-- time_format(S2.arrival_time, '%H:%i') as 'to_time',
-- TS._SL as 'status_sl',
-- round((S2.dist - S1.dist) * f_sl, 2) as 'fare_sl',
-- TS._1A as 'status_1a',
-- round((S2.dist - S1.dist) * f_1a, 2) as 'fare_1a',
-- TS._2A as 'status_2a',
-- round((S2.dist - S1.dist) * f_2a, 2) as 'fare_2a',
-- TS._3A as 'status_3a',
-- round((S2.dist - S1.dist) * f_3a, 2) as 'fare_3a'

-- from TRAIN T, TRAIN_STATUS TS, STATION S1, STATION S2
-- where TS.date=? and S1.station_name=? and S2.station_name=?
-- and T.train_no = TS.train_no
-- and S1.train_no = T.train_no and T.train_no = S2.train_no;


-- ALTER TABLE PASSENGER
-- MODIFY COLUMN passenger_id INT NOT NULL AUTO_INCREMENT;

-- select * from STATION;
select * from TICKET;
select * from PASSENGER;

-- delete from TICKET;
-- delete from PASSENGER;
-- select * from TRAIN;

-- select * from STATION;

-- delete from TICKET where ticket_id = 890374;
-- delete from PASSENGER where ticket_id = 890374;

-- select status from TICKET T, PASSENGER P where T.ticket_id = P.ticket_id
-- and train_no = 12380 and date = '2023-12-10' and class = '3A';

-- update TICKET set status = 'CNL' where ticket_id = 836491;

select * from TRAIN_STATUS;

select T.status, T.ticket_id from TICKET T, PASSENGER P where T.ticket_id = P.ticket_id
and T.train_no = 12380 and T.date = '2023-12-10' and P.class = 'SL';

-- select * from USER;
