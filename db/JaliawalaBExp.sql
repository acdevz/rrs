-- insert into TRAIN values
-- (12379, 'JALIANWALA B EX', 27.10, 1894, 'x','x','x','x','x','x','Y', 0.4, 1.20, 1.5, 2.8);

INSERT INTO STATION (station_code, name, train_no, arrival_time, departure_time, hault, dist, day)
VALUES 
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



insert into STARTS values
(12379, 'ASR');
insert into STOPS values
(12379, 'SDAH');

