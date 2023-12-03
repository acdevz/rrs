-- insert into TRAIN values
-- (12587, 'AMARNATH EXP', 22.40, 1248, 'Y','x','x','x','x','x','x', 0.46, 1.22, 1.70, 3.00);

-- INSERT INTO STATION (station_code, name, train_no, arrival_time, departure_time, hault, dist, day)
-- VALUES 
--     ('GKP', 'Gorakhpur', '12578', '14:20', '14:20', 0, 0, 1),
--     ('KLD', 'Khalilabad', '12578', '14:54', '14:56', 2, 35, 1),
--     ('BST', 'Basti', '12578', '15:19', '15:22', 3, 65, 1),
--     ('GD', 'Gonda Jn', '12578', '16:45', '16:55', 10, 154, 1),
--     ('LKO', 'Lucknow', '12578', '19:20', '19:30', 10, 271, 1),
--     ('SPN', 'Shahjehanpur (PQ)', '12578', '22:20', '22:22', 2, 435, 1),
--     ('BE', 'Bareilly', '12578', '23:21', '23:23', 2, 506, 1),
--     ('MB', 'Moradabad', '12578', '00:57', '01.05', 8, 597, 2),
--     ('LRJ', 'Laksar Jn', '12578', '02:54', '02:56', 2, 736, 2),
--     ('RK', 'Roorkee', '12578', '03:16', '03:18', 2, 754, 2),
--     ('SRE', 'Saharanpur', '12578', '04:15', '04:25', 10, 789, 2),
--     ('YJUD', 'Yamunanagar Jagadhri', '12578', '04:51', '04:53', 2, 819, 2),
--     ('UMB', 'Ambala Cant Jn', '12578', '05:45', '05:50', 5, 870, 2),
--     ('LDH', 'Ludhiana Jn', '12578', '07:26', '07:36', 10, 984, 2),
--     ('JRC', 'Jalandhar Cant', '12578', '08:24', '08:29', 5, 1036, 2),
--     ('PTKC', 'Pathankot Cantt', '12578', '10:30', '10:35', 5, 1149, 2),
--     ('KTHU', 'Kathua', '12578', '11:04', '11:06', 2, 1172, 2),
--     ('JAT', 'Jammu Tawi', '12578', '13:00', '13:00', 0, 1248, 2);


-- insert into STARTS values
-- (12578, 'GKP');
-- insert into STOPS values
-- (12578, 'JAT');

-- select * from TRAIN;

-- insert into TRAIN_STATUS values
-- (12587, 'GNWL4', 'GNWL4', 'GNWL23', 'GNWL83', '2023-12-11'),
-- (12587, 'GNWL3', 'GNWL11', 'GNWL38', 'GNWL96', '2023-12-18');

select * from STATION;
-- update STATION set arrival_time = 0 where station_code = 'GKP';
-- update STATION set departure_time = 0 where station_code = 'JAT';
