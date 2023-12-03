-- insert into TICKET values
-- (10011, 'amanchandra_in', 'CNF', 1, 12587, 'LKO', 'JRC', '2023-11-27'),
-- (10121, 'amanchandra_in', 'CNF', 1, 12587, 'BST', 'LDH', '2023-12-4');
-- (10123, 'amanchandra_in', 'CNF', 1, 12380, 'JUC', 'DLI', '2023-12-18');

-- insert into PASSENGER values
-- (101, '463-3455632', 'Aman Chandra', 19, 'M', 'amanchandra_in', 'SL-S1/32', 10011),
-- (102, '254-3129731', 'Astha Verma', 23, 'F', 'amanchandra_in', '3A-B5/16', 10121);
-- (103, '370-3129891', 'Akash Gupta', 18, 'M', 'amanchandra_in', '1A-A1/4', 10123);

-- select T.train_no, T.train_name, P.name passenger_name, S1.name 'from', S1.departure_time 'time', S2.name 'to', TK.date
-- from PASSENGER P, TICKET TK, TRAIN T, STATION S1, STATION S2
-- where P.ticket_id = TK.ticket_id
-- and TK.train_no = T.train_no
-- and S1.train_no = T.train_no and TK.from = S1.station_code
-- and S2.train_no = T.train_no and TK.to = S2.station_code
-- and TK.date > current_date();